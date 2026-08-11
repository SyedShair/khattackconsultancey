<x-mail.layout>
    
<h2 style="margin:0 0 6px; font-size:20px; color:#1a1a2e;">💬 A Visitor is Waiting</h2>
    <p style="margin:0 0 24px; color:#6b6880; font-size:14px;">
        Someone on your website chose "Talk to Our Team" and is waiting for a reply.
    </p>

    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background:#f8f8fb; border-radius:10px; margin-bottom:24px;">
        <tr>
            <td style="padding:20px;">
                <table role="presentation" width="100%" cellpadding="6" cellspacing="0" style="font-size:14px; color:#333;">
                    <tr>
                        <td style="color:#8a869a; width:110px;">Name</td>
                        <td style="font-weight:600;">{{ $session->name ?: 'Anonymous' }}</td>
                    </tr>
                    @if($session->email)
                        <tr>
                            <td style="color:#8a869a;">Email</td>
                            <td><a href="mailto:{{ $session->email }}" style="color:#6E1299; text-decoration:none;">{{ $session->email }}</a></td>
                        </tr>
                    @endif
                    @if($session->phone)
                        <tr>
                            <td style="color:#8a869a;">Phone</td>
                            <td>{{ $session->phone }}</td>
                        </tr>
                    @endif
                    <tr>
                        <td style="color:#8a869a; vertical-align:top;">Message</td>
                        <td>{{ $session->query }}</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    <a href="{{ url('/admin/live-chat') }}"
       style="display:inline-block; background:linear-gradient(120deg, #3E5B54, #4F6B63); color:#ffffff; text-decoration:none; padding:12px 24px; border-radius:8px; font-weight:600; font-size:14px;">
        Reply Now   
    </a>

    <p style="margin:16px 0 0; font-size:12px; color:#a6a3b8;">
        The visitor is actively waiting in the chat widget — a quick reply makes a great first impression.
    </p>
    </x-mail::layout>