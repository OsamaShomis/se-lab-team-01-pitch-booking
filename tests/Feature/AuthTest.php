<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_screen_can_be_rendered(): void
    {
        $response = $this->get(route('register'));

        $response->assertStatus(200);
        $response->assertSee('إنشاء حساب في كورة بلص');
        $response->assertSee('حساب لاعب');
        $response->assertSee('صاحب ملعب');
    }

    public function test_player_can_register_and_is_redirected_to_pitches(): void
    {
        $response = $this->post(route('register'), [
            'name' => 'أسامة اللاعب',
            'email' => 'player@example.com',
            'phone' => '0501234567',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'role' => 'player',
        ]);

        $this->assertAuthenticated();
        $user = User::where('email', 'player@example.com')->first();
        $this->assertNotNull($user);
        $this->assertEquals('player', $user->role);
        $this->assertTrue(Hash::check('password123', $user->password));

        $response->assertRedirect(route('pitches.index'));
        $response->assertSessionHas('success');
    }

    public function test_owner_can_register_and_is_redirected_to_owner_dashboard(): void
    {
        $response = $this->post(route('register'), [
            'name' => 'صاحب ملعب النجوم',
            'email' => 'owner@example.com',
            'phone' => '0509876543',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'role' => 'owner',
        ]);

        $this->assertAuthenticated();
        $user = User::where('email', 'owner@example.com')->first();
        $this->assertNotNull($user);
        $this->assertEquals('owner', $user->role);

        $response->assertRedirect(route('owner.dashboard'));
        $response->assertSessionHas('success');
    }

    public function test_registration_fails_with_duplicate_email(): void
    {
        User::factory()->create(['email' => 'duplicate@example.com']);

        $response = $this->post(route('register'), [
            'name' => 'مستخدم آخر',
            'email' => 'duplicate@example.com',
            'phone' => '0555555555',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'role' => 'player',
        ]);

        $response->assertSessionHasErrors(['email']);
        $this->assertGuest();
    }

    public function test_registration_fails_with_unconfirmed_password(): void
    {
        $response = $this->post(route('register'), [
            'name' => 'مستخدم تجريبي',
            'email' => 'mismatch@example.com',
            'phone' => '0555555555',
            'password' => 'password123',
            'password_confirmation' => 'differentPassword',
            'role' => 'player',
        ]);

        $response->assertSessionHasErrors(['password']);
        $this->assertGuest();
    }

    public function test_login_screen_can_be_rendered(): void
    {
        $response = $this->get(route('login'));

        $response->assertStatus(200);
        $response->assertSee('تسجيل الدخول');
        $response->assertSee('تذكرني');
    }

    public function test_player_can_login_and_is_redirected_to_pitches(): void
    {
        $user = User::factory()->player()->create([
            'email' => 'player.login@example.com',
            'password' => Hash::make('secret123'),
        ]);

        $response = $this->post(route('login'), [
            'email' => 'player.login@example.com',
            'password' => 'secret123',
        ]);

        $this->assertAuthenticatedAs($user);
        $response->assertRedirect(route('pitches.index'));
    }

    public function test_owner_can_login_and_is_redirected_to_owner_dashboard(): void
    {
        $owner = User::factory()->owner()->create([
            'email' => 'owner.login@example.com',
            'password' => Hash::make('secret123'),
        ]);

        $response = $this->post(route('login'), [
            'email' => 'owner.login@example.com',
            'password' => 'secret123',
        ]);

        $this->assertAuthenticatedAs($owner);
        $response->assertRedirect(route('owner.dashboard'));
    }

    public function test_user_cannot_login_with_invalid_credentials(): void
    {
        User::factory()->create([
            'email' => 'correct@example.com',
            'password' => Hash::make('correctPassword'),
        ]);

        $response = $this->post(route('login'), [
            'email' => 'correct@example.com',
            'password' => 'wrongPassword',
        ]);

        $this->assertGuest();
        $response->assertSessionHasErrors(['email']);
    }

    public function test_user_can_logout(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user);
        $this->assertAuthenticated();

        $response = $this->post(route('logout'));

        $this->assertGuest();
        $response->assertRedirect(route('login'));
    }

    public function test_player_cannot_access_owner_dashboard_forbidden(): void
    {
        $player = User::factory()->player()->create();

        $response = $this->actingAs($player)->get(route('owner.dashboard'));

        $response->assertStatus(403);
    }

    public function test_guest_cannot_access_owner_dashboard_redirected(): void
    {
        $response = $this->get(route('owner.dashboard'));

        $response->assertRedirect(route('login'));
    }
}
