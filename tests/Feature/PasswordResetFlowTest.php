<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class PasswordResetFlowTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_page_links_to_forgot_password_form(): void
    {
        $this->get(route('login'))
            ->assertOk()
            ->assertSee(route('password.request'))
            ->assertSee(asset('images/logo-pemkot.png'));

        $this->get(route('password.request'))
            ->assertOk()
            ->assertSee(route('password.email'));
    }

    public function test_reset_link_is_sent_for_registered_email(): void
    {
        Notification::fake();
        $user = $this->createUser();

        $this->post(route('password.email'), ['email' => $user->email])
            ->assertRedirect()
            ->assertSessionHas('status', 'Jika email terdaftar, tautan untuk mengatur ulang sandi akan dikirim.');

        Notification::assertSentTo($user, ResetPassword::class);
    }

    public function test_forgot_password_response_does_not_disclose_unknown_email(): void
    {
        Notification::fake();

        $this->from(route('password.request'))
            ->followingRedirects()
            ->post(route('password.email'), ['email' => 'unknown@example.test'])
            ->assertOk()
            ->assertSee('Jika email terdaftar, tautan untuk mengatur ulang sandi akan dikirim.');

        Notification::assertNothingSent();
    }

    public function test_valid_reset_token_updates_password_and_returns_to_login(): void
    {
        Notification::fake();
        $user = $this->createUser();

        $this->post(route('password.email'), ['email' => $user->email]);

        $token = null;
        Notification::assertSentTo(
            $user,
            ResetPassword::class,
            function (ResetPassword $notification) use (&$token): bool {
                $token = $notification->token;

                return true;
            }
        );

        $this->assertNotNull($token);
        $this->get(route('password.reset', [
            'token' => $token,
            'email' => $user->email,
        ]))
            ->assertOk()
            ->assertSee('Buat sandi baru');

        $this->post(route('password.update'), [
            'token' => $token,
            'email' => $user->email,
            'password' => 'NewSecurePass123!',
            'password_confirmation' => 'NewSecurePass123!',
        ])
            ->assertRedirect(route('login'))
            ->assertSessionHas('status', 'Sandi berhasil diatur ulang. Silakan masuk dengan sandi baru.');

        $this->assertTrue(Hash::check('NewSecurePass123!', $user->fresh()->password));
        $this->assertDatabaseMissing('password_reset_tokens', ['email' => $user->email]);
    }

    public function test_reset_requires_matching_confirmed_password(): void
    {
        $this->post(route('password.update'), [
            'token' => 'invalid-token',
            'email' => 'someone@example.test',
            'password' => 'NewSecurePass123!',
            'password_confirmation' => 'DifferentPass123!',
        ])
            ->assertSessionHasErrors('password');
    }

    private function createUser(): User
    {
        return User::create([
            'name' => 'Test User',
            'email' => 'test@example.test',
            'password' => 'OldSecurePass123!',
            'role' => 'admin',
        ]);
    }
}
