@php
    $location = config('wedding.location');
    $event = config('wedding.resepsi');
@endphp

<section id="scene-location" class="wedding-section overflow-hidden paper-texture" data-nav="Lokasi">
    <x-ui.floral-corners />

    <div class="relative z-10 mb-10 flex flex-col items-center text-center">
        <div class="event-icon-ring reveal">
            <i class="event-icon fa-solid fa-map-location-dot text-xl" aria-hidden="true"></i>
        </div>
        <p class="eyebrow reveal">Petunjuk Arah</p>
        <h3 class="section-title mt-3 font-heading text-3xl text-wedding-ink md:text-4xl reveal">Lokasi Acara</h3>
    </div>

    <div class="map-card wedding-card relative z-10 w-full max-w-2xl reveal">
        <a href="{{ $location['maps_url'] }}" target="_blank" rel="noopener"
           class="map-frame group" aria-label="Buka lokasi acara di Google Maps">
            <iframe src="{{ $location['embed_url'] }}" title="Peta lokasi acara" loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade" tabindex="-1"></iframe>
            <span class="map-pin" aria-hidden="true"><i class="fa-solid fa-location-dot"></i></span>
            <span class="map-hint">
                <i class="fa-solid fa-up-right-from-square" aria-hidden="true"></i> Ketuk untuk membuka peta
            </span>
        </a>

        <div class="mt-6 flex flex-col items-center gap-1 text-center">
            <p class="event-address">{{ $event['address'] }}</p>
            <p class="event-region">{{ $event['district'] }} &middot; {{ $event['city'] }}, {{ $event['province'] }}</p>
            <p class="mt-1 font-body text-[10px] uppercase tracking-[0.3em] text-wedding-deep/45">
                {{ $location['latitude'] }}, {{ $location['longitude'] }}
            </p>
        </div>

        <div class="mt-6 flex flex-col gap-3 sm:flex-row sm:justify-center">
            <a href="{{ $location['maps_url'] }}" target="_blank" rel="noopener"
               class="btn-wedding bg-wedding-deep text-white hover:bg-wedding-navy">
                <i class="fa-solid fa-map-location-dot" aria-hidden="true"></i> Buka Google Maps
            </a>
            <a href="https://www.google.com/maps/dir/?api=1&destination={{ $location['latitude'] }},{{ $location['longitude'] }}"
               target="_blank" rel="noopener" class="btn-wedding bg-white/80 text-wedding-deep hover:bg-white">
                <i class="fa-solid fa-route" aria-hidden="true"></i> Petunjuk Arah
            </a>
        </div>
    </div>
</section>
