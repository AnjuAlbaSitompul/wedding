@php
    $person = config('wedding.bride');
@endphp

<section id="scene-bride" class="wedding-section overflow-hidden">
    <div class="person-card wedding-card relative">
        <img src="{{ asset('images/floral/sprig-soft.webp') }}" alt="" aria-hidden="true" loading="lazy" decoding="async"
             class="person-ornament card-sprig">

        <div class="portrait">
            <div class="portrait-inner">
                @if ($person['photo'])
                    <img src="{{ asset($person['photo']) }}" alt="{{ $person['nickname'] }}">
                @else
                    <i class="fa-solid fa-user text-5xl text-white/90" aria-hidden="true"></i>
                @endif
            </div>
        </div>

        <p class="eyebrow person-meta mb-2">Mempelai Wanita</p>
        <h3 class="font-script text-4xl text-wedding-ink md:text-5xl">{{ $person['nickname'] }}</h3>
        <p class="mt-2 font-elegant text-lg text-wedding-deep/80">{{ $person['full_name'] }}</p>

        <div class="person-divider">
            <p class="mb-1 font-body text-xs uppercase tracking-[0.24em] text-wedding-deep/55">Putri dari</p>
            <p class="font-elegant text-base text-wedding-ink">{{ $person['father'] }}</p>
            <p class="font-elegant text-base text-wedding-ink">&amp; {{ $person['mother'] }}</p>
        </div>

        @if ($person['instagram'])
            <a href="https://instagram.com/{{ $person['instagram'] }}" target="_blank" rel="noopener"
               class="mt-5 inline-block text-wedding-blue transition hover:text-wedding-deep">
                <i class="fa-brands fa-instagram text-2xl"></i>
            </a>
        @endif
    </div>
</section>
