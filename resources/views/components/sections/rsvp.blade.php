@props(['rsvps' => collect()])

<section id="scene-rsvp" class="wedding-section">
    <div class="text-center mb-8">
        <h3 class="font-heading text-3xl md:text-4xl text-wedding-deep reveal">RSVP &amp; Ucapan</h3>
        <p class="font-elegant text-lg text-wedding-deep/60 mt-2 reveal">Konfirmasi kehadiran dan kirim doa terbaik Anda</p>
    </div>

    <div class="grid lg:grid-cols-2 gap-6 max-w-5xl w-full">
        <form id="rsvp-form" method="POST" action="{{ route('rsvp.store') }}" class="wedding-card reveal" novalidate>
            <div class="space-y-4">
                <div>
                    <label for="rsvp-name" class="block font-heading text-sm text-wedding-deep mb-1">Nama</label>
                    <input id="rsvp-name" name="name" type="text" required maxlength="100" autocomplete="name"
                           class="w-full rounded-lg border border-wedding-blue/40 bg-white px-4 py-2 font-body text-sm text-wedding-deep focus:outline-none focus:ring-2 focus:ring-wedding-blue"
                           placeholder="Nama Anda">
                </div>

                <div>
                    <label for="rsvp-attendance" class="block font-heading text-sm text-wedding-deep mb-1">Kehadiran</label>
                    <select id="rsvp-attendance" name="attendance" required
                            class="w-full rounded-lg border border-wedding-blue/40 bg-white px-4 py-2 font-body text-sm text-wedding-deep focus:outline-none focus:ring-2 focus:ring-wedding-blue">
                        <option value="">Pilih kehadiran</option>
                        <option value="hadir">Hadir</option>
                        <option value="tidak_hadir">Berhalangan</option>
                    </select>
                </div>

                <div>
                    <label for="rsvp-guests" class="block font-heading text-sm text-wedding-deep mb-1">Jumlah Orang</label>
                    <select id="rsvp-guests" name="guests"
                            class="w-full rounded-lg border border-wedding-blue/40 bg-white px-4 py-2 font-body text-sm text-wedding-deep focus:outline-none focus:ring-2 focus:ring-wedding-blue">
                        @for ($i = 1; $i <= 5; $i++)
                            <option value="{{ $i }}">{{ $i }}</option>
                        @endfor
                    </select>
                </div>

                <div>
                    <label for="rsvp-message" class="block font-heading text-sm text-wedding-deep mb-1">Pesan</label>
                    <textarea id="rsvp-message" name="message" rows="4" required maxlength="500"
                              class="w-full rounded-lg border border-wedding-blue/40 bg-white px-4 py-2 font-body text-sm text-wedding-deep focus:outline-none focus:ring-2 focus:ring-wedding-blue"
                              placeholder="Tulis doa dan ucapan Anda..."></textarea>
                </div>

                <p id="rsvp-error" class="hidden text-sm text-red-600 font-body"></p>
                <p id="rsvp-success" class="hidden text-sm text-green-700 font-body">Terima kasih, ucapan Anda telah terkirim.</p>

                <button type="submit"
                        class="w-full rounded-full bg-wedding-deep px-6 py-3 font-heading text-sm text-white transition hover:bg-[#0D47A1]">
                    Kirim Ucapan
                </button>
            </div>
        </form>

        <div class="wedding-card reveal">
            <h4 class="font-heading text-lg text-wedding-deep mb-4">Wall of Wishes</h4>
            <div id="rsvp-wall" class="space-y-4 max-h-[28rem] overflow-y-auto pr-1">
                @forelse ($rsvps as $rsvp)
                    <div class="rounded-xl bg-white/70 border border-wedding-blue/20 p-4">
                        <div class="flex items-center justify-between gap-2">
                            <p class="font-heading text-sm text-wedding-deep">{{ $rsvp->name }}</p>
                            <span class="text-[10px] font-body px-2 py-0.5 rounded-full {{ $rsvp->attendance === 'hadir' ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-600' }}">
                                {{ $rsvp->attendance === 'hadir' ? 'Hadir' : 'Berhalangan' }}
                            </span>
                        </div>
                        <p class="font-body text-sm text-wedding-deep/70 mt-2">{{ $rsvp->message }}</p>
                        <p class="font-body text-[10px] text-wedding-deep/40 mt-2">{{ $rsvp->created_at->diffForHumans() }}</p>
                    </div>
                @empty
                    <p id="rsvp-empty" class="font-body text-sm text-wedding-deep/50">Belum ada ucapan. Jadilah yang pertama!</p>
                @endforelse
            </div>
        </div>
    </div>
</section>
