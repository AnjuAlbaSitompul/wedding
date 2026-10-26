@php
    $event = config('wedding.akad');
@endphp

<section id="scene-akad" class="wedding-section">
    <div class="text-center mb-8">
        <i class="fa-solid fa-mosque text-5xl text-wedding-blue mb-4 reveal"></i>
        <h3 class="font-heading text-3xl md:text-4xl text-wedding-deep reveal">Akad Nikah</h3>
    </div>

    <div class="wedding-card max-w-lg stagger-children">
        <div class="flex items-center justify-center gap-4 mb-6">
            <i class="fa-solid fa-calendar-day text-wedding-blue text-2xl"></i>
            <div class="text-center">
                <p class="font-heading text-xl text-wedding-deep">{{ $event['day'] }}</p>
                <p class="font-script text-4xl text-wedding-deep">{{ $event['date'] }}</p>
            </div>
        </div>

        <div class="space-y-2 text-center">
            <p class="font-elegant text-lg text-wedding-deep/80">
                <i class="fa-solid fa-clock text-wedding-blue mr-2"></i>{{ $event['time'] }}
            </p>
            <p class="font-body text-sm text-wedding-deep/70">{{ $event['address'] }}</p>
            <p class="font-body text-sm text-wedding-deep/60">{{ $event['district'] }} - {{ $event['subdistrict'] }}</p>
            <p class="font-body text-sm text-wedding-deep/60">{{ $event['city'] }} - {{ $event['province'] }} kode pos {{ $event['postal_code'] }}</p>
        </div>

        @if ($event['maps_url'])
            <a href="{{ $event['maps_url'] }}" target="_blank" rel="noopener" class="inline-flex items-center gap-3 mt-4">
                <span class="bg-wedding-blue/80 hover:bg-wedding-blue text-white px-4 rounded-full font-heading text-sm">Lihat Lokasi</span>
            </a>
        @endif
    </div>
</section>
