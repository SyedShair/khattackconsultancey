<x-mail.layout>
        <h2 style="margin:0 0 6px; font-size:20px; color:#1a1a2e;">✅ Your Consultation is Confirmed</h2>
    <p style="margin:0 0 24px; color:#6b6880; font-size:14px;">
        Hi {{ $booking->name }}, thanks for booking with us — here are your details.
    </p>

    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background:#f8f8fb; border-radius:10px; margin-bottom:24px;">
        <tr>
            <td style="padding:20px; text-align:center;">
                <p style="margin:0 0 4px; color:#8a869a; font-size:13px;">DATE &amp; TIME</p>
                <p style="margin:0; font-size:20px; font-weight:700; color:#1a1a2e;">{{ $booking->formatted_slot }}</p>
            </td>
        </tr>
    </table>

    @if($booking->query)
        <p style="margin:0 0 4px; color:#8a869a; font-size:13px;">WHAT YOU'D LIKE TO DISCUSS</p>
        <p style="margin:0 0 24px; font-size:14px; color:#333;">{{ $booking->query }}</p>
    @endif

    <p style="margin:0; font-size:14px; color:#333; line-height:1.7;">
        If anything changes on our end, we'll reach out at {{ $booking->email }} or {{ $booking->phone }}.
        If you need to reschedule, just reply to this email and we'll sort it out.
    </p>
</x-mail.layout>