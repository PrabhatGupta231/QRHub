<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\AdminUserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Unauthenticated dashboard redirects to admin login.
     */
    public function test_guest_is_redirected_to_login(): void
    {
        $response = $this->get(route('admin.dashboard'));
        $response->assertRedirect(route('admin.login'));
    }

    /**
     * Admin login with valid credentials succeeds and logs in.
     */
    public function test_admin_can_login_with_valid_credentials(): void
    {
        // Seed admin user
        $this->seed(AdminUserSeeder::class);

        $response = $this->post(route('admin.login.submit'), [
            'email' => 'admin@qrhub.com',
            'password' => 'admin123'
        ]);

        $response->assertRedirect(route('admin.dashboard'));
        $this->assertAuthenticated();
    }

    /**
     * Admin login with invalid credentials fails.
     */
    public function test_admin_cannot_login_with_invalid_credentials(): void
    {
        $this->seed(AdminUserSeeder::class);

        $response = $this->post(route('admin.login.submit'), [
            'email' => 'admin@qrhub.com',
            'password' => 'wrongpassword'
        ]);

        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }
}
