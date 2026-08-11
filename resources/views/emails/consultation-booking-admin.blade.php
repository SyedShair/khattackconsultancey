<x-mail.layout>
        <h2 style="margin:0 0 6px; font-size:20px; color:#1a1a2e;">📅 New Consultation Booking</h2>
    <p style="margin:0 0 24px; color:#6b6880; font-size:14px;">A client just booked a consultation through your website.</p>

    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background:#f8f8fb; border-radius:10px; margin-bottom:24px;">
        <tr>
            <td style="padding:20px;">
                <table role="presentation" width="100%" cellpadding="6" cellspacing="0" style="font-size:14px; color:#333;">
                    <tr>
                        <td style="color:#8a869a; width:110px;">Name</td>
                        <td style="font-weight:600;">{{ $booking->name }}</td>
                    </tr>
                    <tr>
                        <td style="color:#8a869a;">Email</td>
                        <td><a href="mailto:{{ $booking->email }}" style="color:#6E1299; text-decoration:none;">{{ $booking->email }}</a></td>
                    </tr>
                    <tr>
                        <td style="color:#8a869a;">Phone</td>
                        <td>{{ $booking->phone }}</td>
                    </tr>
                    <tr>
                        <td style="color:#8a869a;">Date &amp; Time</td>
                        <td style="font-weight:600;">{{ $booking->formatted_slot }}</td>
                    </tr>
                    @if($booking->query)
                        <tr>
                            <td style="color:#8a869a; vertical-align:top;">Query</td>
                            <td>{{ $booking->query }}</td>
                        </tr>
                    @endif
                </table>
            </td>
        </tr>
    </table>
                        

    <a href="{{ url('/admin/consultation-bookings') }}"
       style="display:inline-block; background:linear-gradient(120deg, #3E5B54, #4F6B63); color:#ffffff; text-decoration:none; padding:12px 24px; border-radius:8px; font-weight:600; font-size:14px;">
        View in Admin Panel
    </a>
    </x-mail::layout>