<?php

namespace App\Http\Controllers;

use App\Models\ConsultationBooking;
use Illuminate\Http\Request;

class ConsultationBookingController extends Controller
{
    public function index()
    {
        return view('consultation-bookings.index');
    }

    public function data(Request $request)
    {
        $query = ConsultationBooking::orderByDesc('booking_date')->orderByDesc('start_time');

        if ($search = $request->get('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        if ($status = $request->get('status')) {
            $query->where('status', $status);
        }

        $perPage = (int) $request->get('per_page', 10);
        $bookings = $query->paginate($perPage)->withQueryString();

        $bookings->getCollection()->transform(fn (ConsultationBooking $b) => [
            'id'      => $b->id,
            'name'    => $b->name,
            'email'   => $b->email,
            'phone'   => $b->phone,
            'query'   => $b->query ? \Illuminate\Support\Str::limit($b->query, 60) : '—',
            'slot'    => $b->formatted_slot,
            'status'  => $b->status,
        ]);

        return response()->json([
            'data'         => $bookings->items(),
            'current_page' => $bookings->currentPage(),
            'last_page'    => $bookings->lastPage(),
            'total'        => $bookings->total(),
        ]);
    }

    public function show(ConsultationBooking $consultationBooking)
    {
        return response()->json([
            'id'      => $consultationBooking->id,
            'name'    => $consultationBooking->name,
            'email'   => $consultationBooking->email,
            'phone'   => $consultationBooking->phone,
            'query'   => $consultationBooking->query,
            'slot'    => $consultationBooking->formatted_slot,
            'status'  => $consultationBooking->status,
        ]);
    }

    public function updateStatus(Request $request, ConsultationBooking $consultationBooking)
    {
        $validated = $request->validate([
            'status' => ['required', 'string', 'in:' . implode(',', array_keys(ConsultationBooking::STATUSES))],
        ]);

        $consultationBooking->update($validated);

        return response()->json(['message' => "Marked as \"{$consultationBooking->status}\"."]);
    }

    public function destroy(ConsultationBooking $consultationBooking)
    {
        $consultationBooking->delete();

        return response()->json(['message' => 'Booking deleted.']);
    }
}
