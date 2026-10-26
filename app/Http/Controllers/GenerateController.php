<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class GenerateController extends Controller
{
    public function form(Request $request)
    {
        if (! $request->session()->get('generate_authorized', false)) {
            return view('generate', ['authorized' => false]);
        }

        return view('generate', ['authorized' => true]);
    }

    public function authenticate(Request $request)
    {
        $request->validate([
            'password' => 'required|string',
        ], [
            'password.required' => 'Password wajib diisi.',
        ]);

        if ($request->input('password') === config('wedding.generate_password')) {
            $request->session()->put('generate_authorized', true);

            return redirect()->route('generate.form');
        }

        return back()->withErrors(['password' => 'Password salah.'])->withInput();
    }

    public function generate(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'phone' => 'required|string|max:20|regex:/^08[0-9]{8,12}$/',
        ], [
            'name.required' => 'Nama tamu wajib diisi.',
            'name.max' => 'Nama maksimal 100 karakter.',
            'phone.required' => 'Nomor WhatsApp tamu wajib diisi.',
            'phone.regex' => 'Format nomor WhatsApp tidak valid. Contoh: 08123456789.',
        ]);

        $guestName = $request->input('name');
        $encrypted = Crypt::encryptString($guestName);
        $token = rtrim(strtr($encrypted, '+/', '-_'), '=');
        $url = route('invitation', ['g' => $token]);

        $phone = preg_replace('/^0/', '62', preg_replace('/\D/', '', $request->input('phone')));
        $waMessage = $this->buildPersonalWhatsAppMessage($guestName, $url);
        $waLink = 'https://wa.me/'.$phone.'?text='.urlencode($waMessage);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'url' => $url,
                'wa_link' => $waLink,
                'preview' => 'Kepada Yth. '.$guestName,
            ]);
        }

        return view('generate', [
            'authorized' => true,
            'result' => [
                'url' => $url,
                'wa_link' => $waLink,
                'preview' => 'Kepada Yth. '.$guestName,
                'name' => $guestName,
            ],
        ]);
    }

    public function logout(Request $request)
    {
        $request->session()->forget('generate_authorized');

        return redirect()->route('generate.form');
    }

    private function buildPersonalWhatsAppMessage(string $guestName, string $url): string
    {
        return "Assalamu'alaikum Warahmatullahi Wabarakatuh \xF0\x9F\xA4\x8D\n\n"
            ."Kami bermaksud mengundang Bapak/Ibu/Saudara/i untuk menghadiri acara pernikahan kami.\n\n"
            ."\xF0\x9F\x92\x9D Dani & Desi\n"
            ."\xF0\x9F\x93\x85 Sabtu, 28 November 2026\n"
            ."\xF0\x9F\x95\x92 09.00 WIB s/d Selesai\n"
            ."\xF0\x9F\x93\x8D Belawan, Medan\n\n"
            ."Klik link berikut untuk melihat undangan:\n"
            .$url."\n\n"
            ."Merupakan suatu kehormatan bagi kami atas kehadiran dan doa restu Anda. \xF0\x9F\xA4\xB2";
    }
}
