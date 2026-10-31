@php
    $person = config('wedding.groom');
@endphp

<section id="scene-groom" class="wedding-section overflow-hidden">
    <div class="person-card wedding-card relative">
        <img src="{{ asset('images/floral/sprig-soft.webp') }}" alt="" aria-hidden="true" loading="lazy" decoding="async"
             class="person-ornament card-sprig">

        <div class="monogram" aria-hidden="true">
            <span>{{ mb_substr($person['nickname'], 0, 1) }}</span>
        </div>

        <p class="eyebrow person-meta mb-2">Mempelai Pria</p>
        <h3 class="font-script text-4xl text-wedding-ink md:text-5xl">{{ $person['nickname'] }}</h3>
        <p class="mt-2 font-elegant text-lg text-wedding-deep/80">{{ $person['full_name'] }}</p>

        <div class="person-divider">
            <p class="mb-1 font-body text-xs uppercase tracking-[0.24em] text-wedding-deep/55">Putra dari</p>
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
