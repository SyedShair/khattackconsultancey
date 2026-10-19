<!DOCTYPE html>
<html lang="en-GB">
<head>
<meta charset="utf-8">
<title>Application – {{ $application->name }}</title>
<style>
  body{font-family:DejaVu Sans,sans-serif;font-size:12px;color:#222a38;line-height:1.5}
  h1{font-size:20px;color:#2f3b52;margin:0 0 4px}
  h2{font-size:13px;color:#2f3b52;border-bottom:1px solid #d5d9e1;padding-bottom:4px;margin:22px 0 8px}
  .muted{color:#6b7385}
  .head{border-bottom:3px solid #2f3b52;padding-bottom:12px;margin-bottom:6px}
  table{width:100%;border-collapse:collapse}
  td{padding:5px 0;vertical-align:top}
  td.label{width:150px;color:#6b7385}
  .box{background:#f4f6f9;padding:10px 12px;white-space:pre-wrap}
  .page-break{page-break-before:always}
  .rich h3{font-size:12px;color:#2f3b52;margin:14px 0 4px}
  .rich p{margin:0 0 8px}
  .rich ul,.rich ol{margin:0 0 8px;padding-left:18px}
  .foot{margin-top:30px;font-size:10px;color:#6b7385}
</style>
</head>
<body>

<div class="head">
  <h1>Job application</h1>
  <div class="muted">Skill Up Notts Ltd</div>
</div>

<h2>Position</h2>
<table>
  @if($application->vacancy)
    <tr><td class="label">Job title</td><td>{{ $application->vacancy->title }}</td></tr>
    @if($application->vacancy->department)
      <tr><td class="label">Department</td><td>{{ $application->vacancy->department }}</td></tr>
    @endif
    @if($application->vacancy->location)
      <tr><td class="label">Location</td><td>{{ $application->vacancy->location }}</td></tr>
    @endif
    <tr><td class="label">Type</td><td>{{ \App\Models\Vacancy::TYPES[$application->vacancy->type] }}</td></tr>
    @if($application->vacancy->salary_range)
      <tr><td class="label">Salary</td><td>{{ $application->vacancy->salary_range }}</td></tr>
    @endif
    @if($application->vacancy->deadline)
      <tr><td class="label">Closing date</td><td>{{ $application->vacancy->deadline->format('j M Y') }}</td></tr>
    @endif
  @else
    <tr><td class="label">Job title</td><td>General application (no specific vacancy)</td></tr>
  @endif
</table>

<h2>Applicant</h2>
<table>
  <tr><td class="label">Full name</td><td>{{ $application->name }}</td></tr>
  <tr><td class="label">Email</td><td>{{ $application->email }}</td></tr>
  <tr><td class="label">Phone</td><td>{{ $application->phone }}</td></tr>
  @if($application->current_location)
    <tr><td class="label">Location</td><td>{{ $application->current_location }}</td></tr>
  @endif
  <tr><td class="label">CV</td><td>Uploaded</td></tr>
</table>

@if($application->highest_qualification || $application->years_experience)
  <h2>Qualifications and experience</h2>
  <table>
    @if($application->highest_qualification)
      <tr><td class="label">Highest qualification</td><td>{{ \App\Models\Application::QUALIFICATIONS[$application->highest_qualification] ?? $application->highest_qualification }}</td></tr>
    @endif
    @if($application->years_experience)
      <tr><td class="label">Relevant experience</td><td>{{ \App\Models\Application::EXPERIENCE[$application->years_experience] ?? $application->years_experience }}</td></tr>
    @endif
  </table>
@endif

@if(!is_null($application->right_to_work))
  <h2>Right to work</h2>
  <table>
    <tr><td class="label">Right to work in the UK</td><td>{{ $application->right_to_work ? 'Yes' : 'No' }}</td></tr>
    @if(!is_null($application->requires_sponsorship))
      <tr><td class="label">Requires sponsorship</td><td>{{ $application->requires_sponsorship ? 'Yes' : 'No' }}</td></tr>
    @endif
  </table>
@endif

@if($application->suitability)
  <h2>Why I am suitable for this position</h2>
  <div class="box">{{ $application->suitability }}</div>
@endif

@if($application->cover_letter)
  <h2>Cover letter</h2>
  <div class="box">{{ $application->cover_letter }}</div>
@endif

@if($application->vacancy)
  <div class="page-break"></div>

  <h1>{{ $application->vacancy->title }}</h1>
  <div class="muted">Job details as advertised</div>

  <h2>Job description</h2>
  <div class="rich">{!! \App\Support\JobText::format($application->vacancy->description) !!}</div>

  @if($application->vacancy->requirements)
    <h2>Requirements</h2>
    <div class="rich">{!! \App\Support\JobText::format($application->vacancy->requirements) !!}</div>
  @endif
@endif

<div class="foot">
  @if($application->declaration_accepted)
    Declaration confirmed: information is accurate and may be processed for recruitment purposes.<br>
  @endif
  Submitted {{ $application->created_at->format('j M Y, H:i') }} · Reference #{{ $application->id }}
</div>

</body>
</html>