@extends('layouts.website')

@section('title', $title . ' – Vocational Training – Skill Up Notts')

@push('styles')
<style>
.vc-hero{background:#2f3d52;color:#fff;padding:clamp(2rem,5vw,4rem) 0 clamp(3rem,7vw,5rem)}
.vc-back{display:inline-block;color:#d3d9e3;text-decoration:none;font-size:.9rem;margin-bottom:1.2rem}
.vc-back:hover{color:#fff;text-decoration:underline}
.vc-hero h1{
  font-family:Georgia,"Times New Roman",serif;font-weight:400;
  text-transform:uppercase;text-align:center;line-height:1.25;
  font-size:clamp(1.7rem,4.6vw,3.4rem);margin:0 auto clamp(1.5rem,4vw,2.5rem);max-width:1100px;
}
.vc-wrap{max-width:1010px;margin:0 auto;text-align:center}

/* list (centred) */
.vc-list{list-style:none;margin:0;padding:0}
.vc-item{
  display:flex;align-items:center;justify-content:center;text-align:center;
  padding:clamp(1rem,2.2vw,1.5rem) 0;border-bottom:1px solid rgba(255,255,255,.18);
  font-size:clamp(1rem,1.7vw,1.4rem);line-height:1.4;
}
.vc-item:first-child{border-top:1px solid rgba(255,255,255,.18)}

/* other categories */
.vc-more{padding:clamp(2.5rem,6vw,4rem) 0}
.vc-more h2{font-family:Georgia,"Times New Roman",serif;font-weight:400;text-transform:uppercase;text-align:center;font-size:clamp(1.3rem,2.6vw,1.9rem);margin:0 0 1.5rem;color:#1c1f26}
.vc-more-list{max-width:1010px;margin:0 auto;display:grid;gap:.9rem;grid-template-columns:repeat(auto-fit,minmax(min(100%,300px),1fr))}
.vc-more-list a{
  display:block;text-align:center;background:#2f3d52;color:#fff;text-decoration:none;
  font-weight:600;letter-spacing:.04em;text-transform:uppercase;font-size:.85rem;padding:1.1rem 1rem;
}
.vc-more-list a:hover{background:#3d506d;color:#fff}
</style>
@endpush

@section('content')
<main>
 <section class="vc-hero">
  <div class="container-xl">

   <div class="vc-wrap">
    <a class="vc-back" href="{{ route('vocational.index') }}">&larr; All vocational training</a>
   </div>

   <h1>{{ $title }}</h1>

   <div class="vc-wrap">
    <ul class="vc-list">
     @foreach($courses as $course)
      <li class="vc-item">{{ $course['name'] }}</li>
     @endforeach
    </ul>
   </div>

  </div>
 </section>

 <section class="vc-more">
  <div class="container-xl">
   <h2>Other categories</h2>
   <div class="vc-more-list">
    @foreach($categories as $s => $cat)
     @continue($s === $slug)
     <a href="{{ route('vocational.show', $s) }}">{{ $cat['title'] }}</a>
    @endforeach
   </div>
  </div>
 </section>
</main>
@endsection