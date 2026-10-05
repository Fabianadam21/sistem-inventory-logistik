<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class PublicRegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_page_links_to_public_registration_form(): void
    {
        $this->get(route('login'))
            ->assertOk()
            ->assertSee(route('register'));

        $this->get(route('register'))
            ->assertOk()
            ->assertSee(route('register.store'));
    }

    public function test_registration_creates_petugas_account_and_redirects_to_login(): void
    {
        $response = $this->post(route('register.store'), [
            'name' => 'New Staff',
            'email' => 'staff@example.test',
            'password' => 'SecurePass123!',
            'password_confirmation' => 'SecurePass123!',
        ]);

        $response->assertRedirect(route('login'))
            ->assertSessionHas('status', 'Pendaftaran berhasil. Silakan masuk menggunakan akun baru Anda.');

        $user = User::where('email', 'staff@example.test')->firstOrFail();
        $this->assertSame('petugas', $user->role);
        $this->assertTrue(Hash::check('SecurePass123!', $user->password));
        $this->assertGuest();
    }

    public function test_public_registration_cannot_assign_a_privileged_role(): void
    {
        $this->post(route('register.store'), [
            'name' => 'Attempted Admin',
            'email' => 'attempted-admin@example.test',
            'password' => 'SecurePass123!',
            'password_confirmation' => 'SecurePass123!',
            'role' => 'admin',
        ])->assertRedirect(route('login'));

        $this->assertDatabaseHas('users', [
            'email' => 'attempted-admin@example.test',
            'role' => 'petugas',
        ]);
    }

    public function test_registration_rejects_duplicate_email_and_unconfirmed_password(): void
    {
        User::create([
            'name' => 'Existing User',
            'email' => 'existing@example.test',
            'password' => 'OldSecurePass123!',
            'role' => 'admin',
        ]);

        $this->post(route('register.store'), [
            'name' => 'Duplicate',
            'email' => 'existing@example.test',
            'password' => 'SecurePass123!',
            'password_confirmation' => 'DifferentPass123!',
        ])->assertSessionHasErrors(['email', 'password']);

        $this->assertDatabaseCount('users', 1);
    }
}
