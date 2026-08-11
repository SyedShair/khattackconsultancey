@php
    $vacancyTitle = $application->vacancy->title ?? 'the role you applied for';

    $statusContent = [
        'pending' => [
            'emoji' => '📋',
            'heading' => 'Your Application is Being Reviewed',
            'body' => "Thanks for applying for <strong>{$vacancyTitle}</strong>. Your application is currently in our queue and hasn't been reviewed yet — we'll follow up as soon as there's an update.",
            'color' => '#6b6880',
        ],
        'reviewed' => [
            'emoji' => '👀',
            'heading' => 'Your Application Has Been Reviewed',
            'body' => "Good news — our team has reviewed your application for <strong>{$vacancyTitle}</strong>. We're currently deciding on next steps and will be in touch soon.",
            'color' => '#4F6B63',
        ],
        'shortlisted' => [
            'emoji' => '🎉',
            'heading' => "You've Been Shortlisted!",
            'body' => "Congratulations! You've been shortlisted for <strong>{$vacancyTitle}</strong>. Our team will reach out shortly to discuss next steps, which may include an interview.",
            'color' => '#4F6B63',
        ],
        'rejected' => [
            'emoji' => '🙏',
            'heading' => 'Update on Your Application',
            'body' => "Thank you for your interest in <strong>{$vacancyTitle}</strong> and for taking the time to apply. After careful consideration, we've decided to move forward with other candidates for this particular role. We really appreciate the effort you put into your application, and we'd encourage you to apply for future openings that match your background.",
            'color' => '#6b6880',
        ],
        'hired' => [
            'emoji' => '🎊',
            'heading' => 'Congratulations — Welcome Aboard!',
            'body' => "We're thrilled to let you know you've been selected for <strong>{$vacancyTitle}</strong>! Our team will be in touch shortly with next steps and onboarding details.",
            'color' => '#4F6B63',
        ],
    ];

    $content = $statusContent[$application->status] ?? $statusContent['pending'];
@endphp

<x-mail.layout>
    <h2 style="margin:0 0 6px; font-size:20px; color:#1a1a2e;">{{ $content['emoji'] }} {{ $content['heading'] }}</h2>
    <p style="margin:0 0 20px; color:#6b6880; font-size:14px;">Hi {{ $application->name }},</p>

    <p style="margin:0 0 24px; font-size:14px; color:#333; line-height:1.7;">
        {!! $content['body'] !!}
    </p>

    <table role="presentation" cellpadding="0" cellspacing="0" style="margin-bottom:8px;">
        <tr>
            <td style="background:{{ $content['color'] }}1a; border-radius:20px; padding:6px 16px;">
                <span style="color:{{ $content['color'] }}; font-size:13px; font-weight:700; text-transform:uppercase; letter-spacing:.03em;">
                    Status: {{ ucfirst($application->status) }}
                </span>
            </td>
        </tr>
    </table>

    <p style="margin:24px 0 0; font-size:13px; color:#a6a3b8;">
        If you have any questions, just reply to this email — we're happy to help.
    </p>
    </x-mail::layout>