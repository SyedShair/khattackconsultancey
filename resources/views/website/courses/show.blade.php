@extends('layouts.website')

@section('title', $course['title'] . ' – Skill Up Notts')

@push('styles')
<style>
.course-hero{
  background:#2f3d52;color:#fff;
  padding:clamp(2.5rem,6vw,4.5rem) 0 clamp(3rem,7vw,5rem);
}
.course-hero h1{
  font-family:Georgia,"Times New Roman",serif;font-weight:400;
  text-transform:uppercase;text-align:center;line-height:1.25;
  font-size:clamp(1.6rem,4.6vw,3.6rem);
  max-width:1250px;margin:0 auto clamp(2rem,5vw,3.5rem);
}
.course-intro{
  max-width:1010px;margin:-1rem auto clamp(1.5rem,4vw,2.5rem);
  color:#d3d9e3;font-size:clamp(.95rem,1.3vw,1.1rem);line-height:1.7;text-align:center;
}
.award-list{list-style:none;margin:0 auto;padding:0;max-width:1010px}
.award-list li{
  padding:clamp(1.3rem,3vw,2.2rem) 0;
  border-bottom:1px solid rgba(255,255,255,.18);
  font-size:clamp(1.05rem,1.9vw,1.6rem);line-height:1.4;
}
.course-cta{text-align:center;margin-top:clamp(2rem,5vw,3.5rem)}
.btn-enquire{
  display:inline-block;background:#fff;color:#2f3d52;text-decoration:none;
  font-weight:600;letter-spacing:.1em;text-transform:uppercase;font-size:.85rem;
  padding:1rem 2.2rem;border-radius:0;
}
.btn-enquire:hover{background:#e9edf2;color:#2f3d52}
</style>
@endpush

@section('content')
<main>
 <section class="course-hero">
  <div class="container-xl">
   <h1>{{ $course['title'] }}</h1>

   @if(!empty($course['intro']))
    <p class="course-intro">{{ $course['intro'] }}</p>
   @endif

   <ul class="award-list">
    @foreach($course['items'] as $item)
     <li>{!! $item !!}</li>
    @endforeach
   </ul>

   
  </div>
 </section>
</main>
@endsection