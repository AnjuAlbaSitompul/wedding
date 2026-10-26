@php
    $groom = config('wedding.groom');
    $bride = config('wedding.bride');
    $order = config('wedding.name_order', 'bride_first');
    $first = $order === 'bride_first' ? $bride : $groom;
    $second = $order === 'bride_first' ? $groom : $bride;
@endphp

<section id="scene-couple-intro" class="wedding-section overflow-hidden" data-nav="Mempelai">
    <x-ui.floral-corners />

    <div class="relative z-10 text-center">
        <p class="eyebrow reveal">The Wedding Of</p>

        <div class="mt-8 flex flex-col items-center">
            <h2 class="font-script text-6xl leading-none text-wedding-ink reveal md:text-8xl">{{ $first['nickname'] }}</h2>
            <span class="my-2 font-heading text-2xl text-wedding-gold reveal md:my-3 md:text-4xl">&amp;</span>
            <h2 class="font-script text-6xl leading-none text-wedding-ink reveal md:text-8xl">{{ $second['nickname'] }}</h2>
        </div>

        <x-ui.section-divider />

        <p class="font-elegant text-base text-wedding-deep/65 reveal md:text-xl">{{ $first['full_name'] }} &amp; {{ $second['full_name'] }}</p>

        <p class="mt-8 font-body text-[10px] uppercase tracking-[0.4em] text-wedding-deep/45 reveal">28 . 11 . 2026</p>
    </div>
</section>
