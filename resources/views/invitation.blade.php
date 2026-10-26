@extends('layouts.app')

@section('content')
@if (! session()->has('invitation_opened'))
        <div id="entry-overlay" class="entry-overlay">
            <div class="text-center px-6">
                <!-- Lottie envelope animation container -->
                <div id="envelope-lottie" class="w-48 h-48 mx-auto mb-6"></div>
                <p class="font-elegant text-xl text-wedding-deep mb-2">Undangan Pernikahan</p>
                <p class="font-script text-5xl text-wedding-deep mb-4">Dani & Desi</p>
                <p class="font-heading text-sm text-wedding-deep/70 mb-8">Klik untuk membuka undangan</p>
                <i class="fa-solid fa-chevron-down text-2xl text-wedding-blue animate-bounce"></i>
            </div>
        </div>
    @endif

    <audio id="bg-music" loop preload="auto">
        <source src="{{ asset('audio/background.mp3') }}" type="audio/mpeg">
    </audio>

    <x-decorations.music-toggle />

    <x-decorations.flying-birds />
    <x-decorations.falling-leaves />
    <x-decorations.floating-particles />
    <x-decorations.light-rays />

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
