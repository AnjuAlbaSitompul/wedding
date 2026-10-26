@props(['rsvps' => collect()])

<section id="scene-rsvp" class="wedding-section overflow-hidden paper-texture" data-nav="RSVP">
    <x-ui.floral-corners />

    <div class="relative z-10 mb-10 text-center">
        <p class="eyebrow reveal">Konfirmasi Kehadiran</p>
        <h3 class="section-title mt-4 font-heading text-3xl text-wedding-ink reveal md:text-4xl">RSVP &amp; Ucapan</h3>
        <p class="mt-3 font-elegant text-lg text-wedding-deep/60 reveal">Kirim doa terbaik Anda untuk kedua mempelai</p>
    </div>

    <div class="relative z-10 grid w-full max-w-5xl gap-6 lg:grid-cols-2">
        <form id="rsvp-form" method="POST" action="{{ route('rsvp.store') }}" class="wedding-card reveal" novalidate>
            <div class="space-y-4">
                <div>
                    <label for="rsvp-name" class="mb-1.5 block font-heading text-sm text-wedding-ink">Nama</label>
                    <input id="rsvp-name" name="name" type="text" required maxlength="100" autocomplete="name"
                           class="w-full rounded-lg border border-wedding-blue/40 bg-white px-4 py-2 font-body text-sm text-wedding-deep focus:outline-none focus:ring-2 focus:ring-wedding-blue"
                           placeholder="Nama Anda">
                </div>

                <div>
                    <label for="rsvp-attendance" class="mb-1.5 block font-heading text-sm text-wedding-ink">Kehadiran</label>
                    <select id="rsvp-attendance" name="attendance" required
                            class="w-full rounded-lg border border-wedding-blue/40 bg-white px-4 py-2 font-body text-sm text-wedding-deep focus:outline-none focus:ring-2 focus:ring-wedding-blue">
                        <option value="">Pilih kehadiran</option>
                        <option value="hadir">Hadir</option>
                        <option value="tidak_hadir">Berhalangan</option>
                    </select>
                </div>

                <div>
                    <label for="rsvp-guests" class="mb-1.5 block font-heading text-sm text-wedding-ink">Jumlah Orang</label>
                    <select id="rsvp-guests" name="guests"
                            class="w-full rounded-lg border border-wedding-blue/40 bg-white px-4 py-2 font-body text-sm text-wedding-deep focus:outline-none focus:ring-2 focus:ring-wedding-blue">
                        @for ($i = 1; $i <= 5; $i++)
                            <option value="{{ $i }}">{{ $i }}</option>
                        @endfor
                    </select>
                </div>

                <div>
                    <label for="rsvp-message" class="mb-1.5 block font-heading text-sm text-wedding-ink">Pesan</label>
                    <textarea id="rsvp-message" name="message" rows="4" required maxlength="500"
                              class="w-full rounded-lg border border-wedding-blue/40 bg-white px-4 py-2 font-body text-sm text-wedding-deep focus:outline-none focus:ring-2 focus:ring-wedding-blue"
                              placeholder="Tulis doa dan ucapan Anda..."></textarea>
                </div>

                <p id="rsvp-error" class="hidden font-body text-sm text-red-600"></p>
                <p id="rsvp-success" class="hidden font-body text-sm text-green-700">Terima kasih, ucapan Anda telah terkirim.</p>

                <button type="submit" class="btn-wedding w-full bg-wedding-deep text-white hover:bg-wedding-navy">
                    Kirim Ucapan
                </button>
            </div>
        </form>

        <div class="wedding-card reveal">
            <p class="eyebrow mb-4">Wall of Wishes</p>
            <div id="rsvp-wall" class="max-h-[28rem] space-y-4 overflow-y-auto pr-1">
                @forelse ($rsvps as $rsvp)
                    <div class="rounded-xl border border-wedding-blue/20 bg-white/70 p-4">
                        <div class="flex items-center justify-between gap-2">
                            <p class="font-heading text-sm text-wedding-ink">{{ $rsvp->name }}</p>
                            <span class="rounded-full px-2 py-0.5 text-[10px] font-body {{ $rsvp->attendance === 'hadir' ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-600' }}">
                                {{ $rsvp->attendance === 'hadir' ? 'Hadir' : 'Berhalangan' }}
                            </span>
                        </div>
                        <p class="mt-2 font-body text-sm text-wedding-deep/70">{{ $rsvp->message }}</p>
                        <p class="mt-2 font-body text-[10px] text-wedding-deep/40">{{ $rsvp->created_at->diffForHumans() }}</p>
                    </div>
                @empty
                    <p id="rsvp-empty" class="font-body text-sm text-wedding-deep/50">Belum ada ucapan. Jadilah yang pertama!</p>
                @endforelse
            </div>
        </div>
    </div>
</section>
