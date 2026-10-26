@extends('layouts.app')

@push('preload')
    <link rel="preload" as="image" href="{{ asset('images/forest/sky.webp') }}" fetchpriority="high">
    <link rel="preload" as="image" href="{{ asset('images/envelope/paper.webp') }}">
    <link rel="preload" as="image" href="{{ asset('images/envelope/wax-seal.webp') }}">
    <link rel="preload" as="image" href="{{ asset('images/envelope/flowers.webp') }}">
@endpush

@section('content')
    <x-sections.envelope :guest-name="$guestName" />

    <audio id="bg-music" loop preload="none">
        <source src="{{ asset('audio/background.mp3') }}" type="audio/mpeg">
    </audio>

    <x-decorations.music-toggle />

    <x-decorations.falling-leaves />
    <x-decorations.floating-particles />

    <main>
        <x-sections.opening-forest />
        <x-sections.gate />
        <x-sections.characters />
        <x-sections.bismillah />
        <x-sections.guest-greeting :guest-name="$guestName" />
        <x-sections.couple-intro />
        <x-sections.groom />
        <x-sections.bride />
        <x-sections.akad />
        <x-sections.resepsi />
        <x-sections.countdown />
        <x-sections.turut-mengundang />
        <x-sections.gallery />
        <x-sections.rsvp :rsvps="$rsvps" />
        <x-sections.gift />
        <x-sections.closing />
    </main>

    @push('scripts')
        <script src="{{ asset('js/scroll-narrative.js') }}"></script>
        <script src="{{ asset('js/decorations.js') }}"></script>
        <script src="{{ asset('js/countdown.js') }}"></script>
        <script src="{{ asset('js/invitation.js') }}"></script>
        <script src="{{ asset('js/birds.js') }}"></script>
    @endpush
@endsection
