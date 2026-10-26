@php
    $event = config('wedding.resepsi');
@endphp

<section id="scene-resepsi" class="wedding-section overflow-hidden" data-nav="Resepsi">
    <x-ui.floral-corners />

    <div class="relative z-10 mb-10 flex flex-col items-center text-center">
        <div class="event-icon-ring reveal">
            <i class="event-icon fa-solid fa-champagne-glasses text-xl" aria-hidden="true"></i>
        </div>
        <p class="eyebrow reveal">Acara Kedua</p>
        <h3 class="section-title mt-3 font-heading text-3xl text-wedding-ink md:text-4xl reveal">Resepsi</h3>
    </div>

    <div class="event-card wedding-card relative z-10 w-full max-w-lg reveal">
        <div class="event-head">
            <span class="event-weekday">{{ $event['day'] }}</span>
            <span class="event-date">{{ $event['date'] }}</span>
            <span class="event-time"><i class="fa-regular fa-clock mr-2" aria-hidden="true"></i>{{ $event['time'] }}</span>
        </div>

        <div class="event-body">
            <i class="fa-solid fa-location-dot mb-1 text-lg text-wedding-blue" aria-hidden="true"></i>
            <p class="event-address">{{ $event['address'] }}</p>
            <p class="event-region">{{ $event['district'] }} &middot; {{ $event['subdistrict'] }}</p>
            <p class="event-region">{{ $event['city'] }} &mdash; {{ $event['province'] }} {{ $event['postal_code'] }}</p>
        </div>

        @if ($event['maps_url'])
            <div class="mt-7 text-center">
                <a href="{{ $event['maps_url'] }}" target="_blank" rel="noopener" class="btn-wedding bg-wedding-deep text-white hover:bg-wedding-navy">
                    <i class="fa-solid fa-location-dot" aria-hidden="true"></i> Lihat Lokasi
                </a>
            </div>
        @endif
    </div>
</section>
