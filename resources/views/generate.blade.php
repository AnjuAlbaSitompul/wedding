@extends('layouts.app')

@section('content')
    <main class="min-h-screen flex items-center justify-center px-4 py-16">
        <div class="w-full max-w-xl">
            <div class="text-center mb-8">
                <p class="font-elegant text-lg text-wedding-deep/60">Generator Undangan</p>
                <h1 class="font-script text-5xl text-wedding-deep">Dani &amp; Desi</h1>
            </div>

            @if (! $authorized)
                <div class="wedding-card">
                    <h2 class="font-heading text-xl text-wedding-deep mb-4">Masukkan Password</h2>

                    @if ($errors->any())
                        <p class="font-body text-sm text-red-600 mb-3">{{ $errors->first() }}</p>
                    @endif

                    <form method="POST" action="{{ route('generate.auth') }}" class="space-y-4">
                        @csrf

                        <div>
                            <label for="password" class="block font-heading text-sm text-wedding-deep mb-1">Password</label>
                            <input id="password" name="password" type="password" required autofocus
                                   class="w-full rounded-lg border border-wedding-blue/40 bg-white px-4 py-2 font-body text-sm text-wedding-deep focus:outline-none focus:ring-2 focus:ring-wedding-blue">
                        </div>

                        <button type="submit"
                                class="w-full rounded-full bg-wedding-deep px-6 py-3 font-heading text-sm text-white transition hover:bg-[#0D47A1]">
                            Masuk
                        </button>
                    </form>
                </div>
            @else
                <div class="wedding-card">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="font-heading text-xl text-wedding-deep">Buat Link Undangan</h2>
                        <form method="POST" action="{{ route('generate.logout') }}">
                            @csrf
                            <button type="submit" class="font-body text-xs text-wedding-blue hover:text-wedding-deep underline">Keluar</button>
                        </form>
                    </div>

                    <form id="generate-form" method="POST" action="{{ route('generate.create') }}" class="space-y-4" novalidate>
                        @csrf

                        <div>
                            <label for="name" class="block font-heading text-sm text-wedding-deep mb-1">Nama Tamu</label>
                            <input id="name" name="name" type="text" required maxlength="100"
                                   class="w-full rounded-lg border border-wedding-blue/40 bg-white px-4 py-2 font-body text-sm text-wedding-deep focus:outline-none focus:ring-2 focus:ring-wedding-blue"
                                   placeholder="Contoh: Bapak Ahmad Surya">
                        </div>

                        <div>
                            <label for="phone" class="block font-heading text-sm text-wedding-deep mb-1">Nomor WhatsApp Tamu</label>
                            <input id="phone" name="phone" type="tel" required maxlength="20" pattern="^08[0-9]{8,12}$"
                                   class="w-full rounded-lg border border-wedding-blue/40 bg-white px-4 py-2 font-body text-sm text-wedding-deep focus:outline-none focus:ring-2 focus:ring-wedding-blue"
                                   placeholder="Contoh: 08123456789">
                        </div>

                        <p id="generate-error" class="hidden text-sm text-red-600 font-body"></p>

                        <button type="submit"
                                class="w-full rounded-full bg-wedding-deep px-6 py-3 font-heading text-sm text-white transition hover:bg-[#0D47A1]">
                            Generate Link
                        </button>
                    </form>

                    <div id="generate-result" class="hidden mt-6 border-t border-wedding-blue/30 pt-4 space-y-4">
                        <div>
                            <p class="font-heading text-sm text-wedding-deep mb-1">Preview Greeting</p>
                            <p id="result-preview" class="font-script text-2xl text-wedding-deep"></p>
                        </div>

                        <div>
                            <p class="font-heading text-sm text-wedding-deep mb-1">Link Undangan</p>
                            <textarea id="result-url" readonly rows="2"
                                      class="w-full rounded-lg border border-wedding-blue/40 bg-white px-3 py-2 font-body text-xs text-wedding-deep"></textarea>
                        </div>

                        <div class="flex flex-wrap gap-3">
                            <button id="generate-copy" type="button"
                                    class="inline-flex items-center gap-2 rounded-full bg-white/90 px-5 py-2.5 font-heading text-sm text-wedding-deep border border-wedding-blue/50 transition hover:bg-white">
                                <i class="fa-solid fa-copy"></i>
                                <span id="generate-copy-label">Copy Link</span>
                            </button>

                            <a id="generate-wa" href="#" target="_blank" rel="noopener"
                               class="inline-flex items-center gap-2 rounded-full bg-[#25D366] px-5 py-2.5 font-heading text-sm text-white transition hover:brightness-95">
                                <i class="fa-brands fa-whatsapp text-lg"></i>
                                Kirim via WhatsApp
                            </a>
                        </div>
                    </div>
                </div>
            @endif

            <p class="text-center mt-6">
                <a href="{{ route('invitation') }}" class="font-body text-xs text-wedding-blue hover:text-wedding-deep underline">
                    <i class="fa-solid fa-arrow-left mr-1"></i>Kembali ke undangan
                </a>
            </p>
        </div>
    </main>
@endsection

@push('scripts')
    <script src="{{ asset('js/generate.js') }}"></script>
@endpush
