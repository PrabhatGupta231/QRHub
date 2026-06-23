@props(['slot'])

@php
    $adCode = \App\Models\Setting::getValue($slot);
@endphp

@if(!empty(trim($adCode)))
    <div class="ad-container my-6 flex justify-center items-center overflow-hidden">
        {!! $adCode !!}
    </div>
@endif
