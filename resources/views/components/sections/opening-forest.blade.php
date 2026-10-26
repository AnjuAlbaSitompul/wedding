<section id="scene-forest" class="wedding-section relative overflow-hidden">
    <div class="absolute inset-0 z-0 pointer-events-none" data-parallax="0.1" aria-hidden="true">
        <img src="{{ asset('images/forest/sky.webp') }}" alt="" class="w-full h-full object-cover" fetchpriority="high">
    </div>

    <img src="{{ asset('images/forest/trees-far.webp') }}" alt="" aria-hidden="true" decoding="async"
         class="absolute bottom-[14%] left-1/2 -translate-x-1/2 z-10 w-[220%] md:w-full max-w-none opacity-90 pointer-events-none" data-parallax="0.3">

    <img src="{{ asset('images/forest/mist.webp') }}" alt="" aria-hidden="true" decoding="async"
         class="forest-mist absolute bottom-[10%] left-1/2 -translate-x-1/2 z-[15] w-[220%] md:w-[120%] max-w-none opacity-70 pointer-events-none" data-parallax="0.4">

    <img src="{{ asset('images/forest/trees-mid.webp') }}" alt="" aria-hidden="true" decoding="async"
         class="absolute -bottom-px left-1/2 -translate-x-1/2 z-[18] w-[220%] md:w-full max-w-none pointer-events-none" data-parallax="0.55">

    <div class="forest-foreground-left absolute left-0 -bottom-[6%] z-20 w-[26vw] max-w-[180px] pointer-events-none" data-parallax="0.8" aria-hidden="true">
        <img src="{{ asset('images/forest/trees-left.webp') }}" alt="" decoding="async" class="w-full h-auto">
    </div>

    <div class="forest-foreground-right absolute right-0 -bottom-[6%] z-20 w-[26vw] max-w-[180px] pointer-events-none" data-parallax="0.8" aria-hidden="true">
        <img src="{{ asset('images/forest/trees-right.webp') }}" alt="" decoding="async" class="w-full h-auto">
    </div>

    <div class="absolute bottom-0 inset-x-0 h-24 z-[25] bg-gradient-to-b from-transparent to-[#BBDEFB] pointer-events-none" aria-hidden="true"></div>

    <div class="relative z-30 text-center px-4 -mt-[18vh]">
        <p class="font-elegant text-lg md:text-2xl text-wedding-deep/80 mb-4 reveal">Undangan Pernikahan</p>
        <h1 class="font-script title-display title-gradient mb-6 reveal">Dani &amp; Desi</h1>
        <p class="font-heading text-sm md:text-base text-wedding-deep/70 reveal">Scroll untuk membuka undangan</p>
        <i class="fa-solid fa-chevron-down text-3xl text-wedding-deep/60 mt-8 animate-bounce reveal" aria-hidden="true"></i>
    </div>
</section>
