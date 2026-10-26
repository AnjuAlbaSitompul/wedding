@php
    $event = config('wedding.resepsi');
@endphp

<section id="scene-resepsi" class="wedding-section overflow-hidden">
    <x-ui.floral-corners />

    <div class="relative z-10 flex flex-col items-center text-center mb-8">
        <i class="event-icon fa-solid fa-champagne-glasses text-5xl text-wedding-blue mb-4 reveal" aria-hidden="true"></i>
        <h3 class="section-title font-heading text-3xl md:text-4xl text-wedding-deep reveal">Resepsi</h3>
    </div>

    <div class="wedding-card relative z-10 max-w-lg stagger-children">
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
            <div class="text-center mt-6">
                <a href="{{ $event['maps_url'] }}" target="_blank" rel="noopener" class="btn-wedding bg-wedding-deep text-white hover:bg-wedding-navy">
                    <i class="fa-solid fa-location-dot" aria-hidden="true"></i> Lihat Lokasi
                </a>
            </div>
        @endif
    </div>
</section>
