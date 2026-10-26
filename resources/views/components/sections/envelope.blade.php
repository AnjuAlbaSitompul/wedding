@props(['guestName'])

<div id="entry-overlay" class="entry-overlay" role="dialog" aria-modal="true" aria-label="Buka undangan">
    <img src="{{ asset('images/forest/sky.webp') }}" alt="" class="absolute inset-0 w-full h-full object-cover opacity-70 blur-[2px] scale-105" aria-hidden="true" fetchpriority="high">

    <button type="button" id="envelope" class="envelope" aria-label="Buka undangan untuk {{ $guestName }}">
        <span class="envelope-back" aria-hidden="true"></span>
        <span class="envelope-card" aria-hidden="true">
            <span class="font-elegant text-sm text-wedding-deep/70">The Wedding of</span>
            <span class="font-script text-4xl text-wedding-deep">Dani &amp; Desi</span>
            <span class="font-heading text-xs tracking-[0.3em] text-wedding-gold">28 . 11 . 2026</span>
        </span>
        <span class="envelope-front" aria-hidden="true"></span>
        <span class="envelope-flap" aria-hidden="true"></span>
        <span class="envelope-seal" aria-hidden="true">
            <img src="{{ asset('images/envelope/wax-seal.webp') }}" alt="" class="w-full h-full">
            <span class="envelope-seal-initials font-script">D&amp;D</span>
        </span>
        <img src="{{ asset('images/envelope/flowers.webp') }}" alt="" class="envelope-flowers" aria-hidden="true">
    </button>

    <div class="envelope-caption relative z-10 mt-10 px-6 text-center max-w-sm">
        <p class="font-elegant text-wedding-deep/70">Kepada Yth.</p>
        <p class="font-heading text-xl text-wedding-deep break-words">{{ $guestName }}</p>
        <p class="envelope-hint mt-4 font-body text-sm text-wedding-gold">Ketuk amplop untuk membuka</p>
    </div>
</div>
