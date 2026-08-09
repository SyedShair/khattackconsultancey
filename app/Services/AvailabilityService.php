<?php

namespace App\Services;

use App\Models\ConsultationBooking;
use App\Models\Setting;
use Illuminate\Support\Carbon;

class AvailabilityService
{
    /** Each consultation slot is this many minutes long. */
    public const SLOT_MINUTES = 60;

    /** How many upcoming days to offer for booking. */
    public const LOOKAHEAD_DAYS = 14;

    protected const DAY_KEYS = ['sun', 'mon', 'tue', 'wed', 'thu', 'fri', 'sat'];

    /**
     * List of upcoming dates with whether the business is open that day,
     * based on Settings opening hours. Used to render date-picker chips.
     */
    public function upcomingDates(): array
    {
        $setting = Setting::first();
        $hours = $setting->opening_hours ?? [];

        $dates = [];
        for ($i = 0; $i < self::LOOKAHEAD_DAYS; $i++) {
            $date = Carbon::today()->addDays($i);
            $dayKey = self::DAY_KEYS[$date->dayOfWeek];
            $dayConfig = $hours[$dayKey] ?? ['closed' => true];
            $isClosed = ! empty($dayConfig['closed']);

            $dates[] = [
                'date'    => $date->toDateString(),
                'label'   => $date->format('D, M j'),
                'is_open' => ! $isClosed,
            ];
        }

        return $dates;
    }

    /**
     * Bookable slots for a single date: generated from that weekday's
     * open/close time in Settings, minus already-confirmed bookings,
     * minus any slot that has already passed (if the date is today).
     */
    public function slotsForDate(string $date): array
    {
        $setting = Setting::first();
        $hours = $setting->opening_hours ?? [];

        $carbonDate = Carbon::parse($date);
        $dayKey = self::DAY_KEYS[$carbonDate->dayOfWeek];
        $dayConfig = $hours[$dayKey] ?? ['closed' => true];

        if (! empty($dayConfig['closed']) || empty($dayConfig['open']) || empty($dayConfig['close'])) {
            return [];
        }

        $open = Carbon::parse($date . ' ' . $dayConfig['open']);
        $close = Carbon::parse($date . ' ' . $dayConfig['close']);

        if ($open->gte($close)) {
            return [];
        }

        $booked = ConsultationBooking::where('booking_date', $date)
            ->where('status', 'confirmed')
            ->pluck('start_time')
            ->map(fn ($t) => Carbon::parse($date . ' ' . $t)->format('H:i'))
            ->all();

        $now = Carbon::now();
        $slots = [];
        $cursor = $open->copy();

        while ($cursor->copy()->addMinutes(self::SLOT_MINUTES)->lte($close)) {
            $slotEnd = $cursor->copy()->addMinutes(self::SLOT_MINUTES);
            $isPast = $carbonDate->isToday() && $cursor->lte($now);
            $isBooked = in_array($cursor->format('H:i'), $booked, true);

            if (! $isPast && ! $isBooked) {
                $slots[] = [
                    'start' => $cursor->format('H:i'),
                    'end'   => $slotEnd->format('H:i'),
                    'label' => $cursor->format('g:i A') . ' - ' . $slotEnd->format('g:i A'),
                ];
            }

            $cursor->addMinutes(self::SLOT_MINUTES);
        }

        return $slots;
    }

    /**
     * Re-validates a requested slot is still bookable right before
     * actually creating the booking (guards against a race where two
     * visitors pick the same slot at nearly the same time).
     */
    public function isSlotAvailable(string $date, string $startTime): bool
    {
        foreach ($this->slotsForDate($date) as $slot) {
            if ($slot['start'] === Carbon::parse($startTime)->format('H:i')) {
                return true;
            }
        }

        return false;
    }
}
