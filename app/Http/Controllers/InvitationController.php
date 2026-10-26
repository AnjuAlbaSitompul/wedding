<?php

namespace App\Http\Controllers;

use App\Models\Rsvp;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class InvitationController extends Controller
{
    public function index(Request $request)
    {
        $guestName = $this->resolveGuestName($request);

        $rsvps = Rsvp::latest()->limit(50)->get();

        return view('invitation', [
            'guestName' => $guestName,
            'rsvps' => $rsvps,
        ]);
    }

    public function storeRsvp(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'attendance' => 'required|in:hadir,tidak_hadir',
            'guests' => 'nullable|integer|min:1|max:5',
            'message' => 'required|string|max:500',
        ]);

        $rsvp = Rsvp::create([
            'name' => $validated['name'],
            'attendance' => $validated['attendance'],
            'guests' => $validated['guests'] ?? 1,
            'message' => $validated['message'],
            'ip_address' => $request->ip(),
        ]);

        return response()->json([
            'success' => true,
            'rsvp' => [
                'name' => $rsvp->name,
                'attendance' => $rsvp->attendance,
                'guests' => $rsvp->guests,
                'message' => $rsvp->message,
                'created_at' => $rsvp->created_at->diffForHumans(),
            ],
        ]);
    }

    private function resolveGuestName(Request $request): string
    {
        $token = $request->query('g');
        $default = 'Bapak/Ibu/Saudara/i';

        if (! $token) {
            return $default;
        }

        try {
            $encrypted = strtr((string) $token, '-_', '+/');
            $pad = strlen($encrypted) % 4;
            if ($pad) {
                $encrypted .= str_repeat('=', 4 - $pad);
            }

            return Crypt::decryptString($encrypted) ?: $default;
        } catch (\Throwable) {
            return $default;
        }
    }
}
