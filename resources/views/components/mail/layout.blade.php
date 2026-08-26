@php
    $appSetting = \App\Models\Setting::first();
    $companyName = $appSetting->app_name ?? config('app.name');
@endphp
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $subject ?? $companyName }}</title>
</head>
<body style="margin:0; padding:0; background:#f4f4f7; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;">

    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background:#f4f4f7; padding:32px 16px;">
        <tr>
            <td align="center">
                <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="max-width:560px; background:#ffffff; border-radius:14px; overflow:hidden; box-shadow:0 4px 18px rgba(10,6,36,0.08);">

                    {{-- Header --}}
                    <tr>
                        <td style="background: linear-gradient(120deg, #3E5B54, #4F6B63, #607570); padding:24px 32px;">
                            <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td>
                                        @if($appSetting->logo ?? false)

                                            <img src="{{ Storage::url($appSetting->logo) }}"" alt="{{ $companyName }}" height="32" style="display:block; border-radius:6px;">
                                        @else
                                            <span style="color:#ffffff; font-size:18px; font-weight:700;">{{ $companyName }}</span>
                                        @endif
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    {{-- Body --}}
                    <tr>
                        <td style="padding:32px;">
                            {{ $slot }}
                        </td>
                    </tr>

                    {{-- Footer --}}
                    <tr>
                        <td style="padding:20px 32px; background:#f8f8fb; border-top:1px solid #eee;">
                            <p style="margin:0; font-size:12px; color:#8a869a; line-height:1.6;">
                                {{ $companyName }}
                                @if($appSetting->address ?? false)
                                    · {{ $appSetting->address }}
                                @endif
                                <br>
                                @if($appSetting->phone ?? false)
                                    {{ $appSetting->phone }}
                                @endif
                                @if($appSetting->email ?? false)
                                    · {{ $appSetting->email }}
                                @endif
                            </p>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>

</body>
</html>