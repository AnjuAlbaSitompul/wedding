@php
    $groom = config('wedding.groom');
    $bride = config('wedding.bride');
    $order = config('wedding.name_order', 'bride_first');
    $first = $order === 'bride_first' ? $bride : $groom;
    $second = $order === 'bride_first' ? $groom : $bride;
@endphp

<section id="scene-couple-intro" class="wedding-section overflow-hidden">
    <x-ui.floral-corners />

    <div class="relative z-10 text-center">
        <p class="font-heading text-xl md:text-3xl text-wedding-deep/70 tracking-[0.3em] uppercase mb-6 reveal">
            The Wedding Of
        </p>

        <div class="flex flex-col items-center gap-2 md:gap-4">
            <h2 class="font-script text-6xl md:text-8xl text-wedding-deep reveal">{{ $first['nickname'] }}</h2>
            <p class="font-heading text-2xl md:text-4xl text-wedding-blue reveal">&amp;</p>
            <h2 class="font-script text-6xl md:text-8xl text-wedding-deep reveal">{{ $second['nickname'] }}</h2>
        </div>

        <x-ui.section-divider />

        <p class="font-elegant text-lg md:text-xl text-wedding-deep/60 reveal">{{ $first['full_name'] }} &amp; {{ $second['full_name'] }}</p>
    </div>
</section>
