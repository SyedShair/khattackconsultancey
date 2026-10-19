@extends('layouts.website')

@section('title', 'Vocational Training – Skill Up Notts')

@push('styles')
<style>
.voc-page{padding:clamp(2.5rem,6vw,4.5rem) 0 clamp(3rem,8vw,6rem)}
.voc-page h1{
  font-family:Georgia,"Times New Roman",serif;font-weight:400;
  text-transform:uppercase;text-align:center;color:#1c1f26;
  font-size:clamp(1.9rem,5vw,3.6rem);margin:0 0 clamp(1.8rem,4vw,3rem);
}
.voc-list{max-width:1010px;margin:0 auto;display:grid;gap:1.25rem}
.voc-bar{
  display:block;background:#2f3d52;color:#fff;text-decoration:none;text-align:center;
  font-weight:600;letter-spacing:.05em;text-transform:uppercase;
  font-size:clamp(.85rem,1.4vw,1.1rem);line-height:1.3;
  padding:clamp(1.2rem,2.4vw,1.65rem) 1rem;
  transition:background .2s ease,transform .2s ease;
}
.voc-bar:hover,.voc-bar:focus-visible{background:#3d506d;color:#fff;transform:translateY(-2px)}
.voc-bar:focus-visible{outline:3px solid #8ea2c0;outline-offset:3px}
@media (prefers-reduced-motion:reduce){.voc-bar{transition:none}.voc-bar:hover{transform:none}}
</style>
@endpush

@section('content')
<main class="voc-page">
 <div class="container-xl">
  <h1>Vocational Training</h1>

  <nav class="voc-list" aria-label="Vocational training categories">
   @foreach($categories as $slug => $cat)
    <a class="voc-bar" href="{{ route('vocational.show', $slug) }}">{{ $cat['title'] }}</a>
   @endforeach
  </nav>
 </div>
</main>
@endsection