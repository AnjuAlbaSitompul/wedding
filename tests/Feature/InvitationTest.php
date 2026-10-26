<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Crypt;
use Tests\TestCase;

class InvitationTest extends TestCase
{
    use RefreshDatabase;

    private function encryptGuestName(string $name): string
    {
        $encrypted = Crypt::encryptString($name);

        return rtrim(strtr($encrypted, '+/', '-_'), '=');
    }

    public function test_invitation_page_renders_generic_greeting_without_token(): void
    {
        $response = $this->get('/');

        $response->assertOk();
        $response->assertSee('Bapak/Ibu/Saudara/i');
        $response->assertSee('Dani');
        $response->assertSee('Desi');
    }

    public function test_invitation_page_decrypts_valid_guest_token(): void
    {
        $token = $this->encryptGuestName('Bapak Ahmad Surya');

        $response = $this->get('/?g='.$token);

        $response->assertOk();
        $response->assertSee('Bapak Ahmad Surya');
    }

    public function test_invitation_page_falls_back_to_generic_greeting_for_invalid_token(): void
    {
        $response = $this->get('/?g=token-tidak-valid');

        $response->assertOk();
        $response->assertSee('Bapak/Ibu/Saudara/i');
    }

    public function test_rsvp_can_be_stored(): void
    {
        $response = $this->postJson('/rsvp', [
            'name' => 'Bapak Ahmad',
            'attendance' => 'hadir',
            'guests' => 2,
            'message' => 'Selamat menempuh hidup baru.',
        ]);

        $response->assertOk();
        $response->assertJsonPath('success', true);
        $this->assertDatabaseHas('rsvps', [
            'name' => 'Bapak Ahmad',
            'attendance' => 'hadir',
        ]);
    }

    public function test_rsvp_validation_rejects_invalid_payload(): void
    {
        $response = $this->postJson('/rsvp', [
            'name' => '',
            'attendance' => 'unknown',
            'guests' => 99,
            'message' => '',
        ]);

        $response->assertUnprocessable();
        $response->assertJsonValidationErrors(['name', 'attendance', 'guests', 'message']);
        $this->assertDatabaseCount('rsvps', 0);
    }

    public function test_generate_page_requires_password_until_authenticated(): void
    {
        $response = $this->get('/generate');

        $response->assertOk();
        $response->assertSee('Masukkan Password');
        $response->assertDontSee('Buat Link Undangan');
    }

    public function test_generate_page_rejects_wrong_password(): void
    {
        $response = $this->from('/generate')->post('/generate/auth', [
            'password' => 'password-salah',
        ]);

        $response->assertRedirect('/generate');
        $response->assertSessionHasErrors('password');
        $response->assertSessionMissing('generate_authorized');
    }

    public function test_generate_link_contains_decryptable_guest_name(): void
    {
        $response = $this->withSession(['generate_authorized' => true])
            ->postJson('/generate', [
                'name' => 'Ibu Siti Aminah',
                'phone' => '08123456789',
            ]);

        $response->assertOk();
        $response->assertJsonPath('success', true);
        $response->assertJsonPath('preview', 'Kepada Yth. Ibu Siti Aminah');

        $url = $response->json('url');
        $this->assertStringContainsString('?g=', $url);

        parse_str(parse_url($url, PHP_URL_QUERY), $query);

        $decrypted = Crypt::decryptString(strtr($query['g'], '-_', '+/'));

        $this->assertSame('Ibu Siti Aminah', $decrypted);
    }

    public function test_generate_endpoint_requires_authorization(): void
    {
        $response = $this->post('/generate', [
            'name' => 'Bapak Tanpa Izin',
            'phone' => '08123456789',
        ]);

        $response->assertRedirect('/generate');
        $this->assertDatabaseCount('rsvps', 0);
    }
}
