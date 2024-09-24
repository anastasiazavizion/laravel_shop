<?php
namespace Tests\Feature\Auth;

use App\Enum\Role;
use App\Models\User;
use Tests\Feature\Traits\SetupTrait;
use Tests\TestCase;

class AuthControllerTest extends TestCase
{
    use SetupTrait;

    /**
     * A basic feature test example.
     */
    public function test_success_login_with_valid_data(): void
    {
        $password = 'password';
        $user = User::factory()->createOne([
            'password' => $password
        ]);
        $this->assertDatabaseHas(User::class, ['email' => $user->email]);

        $response = $this->postJson(route('v1.login'), [
            'email' => $user->email,
            'password' => $password,
        ]);

        $response->assertStatus(200);
        $response->assertJson('Authenticated');
        $this->assertAuthenticatedAs($user);
    }

    public function test_fail_login_with_not_present_data(): void
    {
        $data = [
            'email'=>'test@gmail.com',
            'password'=>'password'
        ];
        $this->assertDatabaseMissing(User::class, ['email' => $data['email']]);
        $response = $this->postJson(route('v1.login'), $data);
        $response->assertJson('Unauthorized');
        $response->assertStatus(403);
        $this->assertInvalidCredentials($data);
        $this->assertGuest();
    }

    public function test_fail_login_with_invalid_data(): void
    {
        $data = [
            'email'=>'email',
            'password'=>''
        ];
        $this->assertDatabaseMissing(User::class, ['email' => $data['email']]);
        $response = $this->postJson(route('v1.login'), $data);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['email', 'password']);
        $response->assertJsonIsObject('errors');
    }

    public function test_success_admin_view_products(): void
    {
        $user = $this->user();
        $response = $this->actingAs($user)->getJson(route('v1.admin.products.index'));
        $response->assertStatus(200);
    }

    public function test_success_moderator_view_products(): void
    {
        $user = $this->user(Role::MODERATOR);
        $response = $this->actingAs($user)->getJson(route('v1.admin.products.index'));
        $response->assertStatus(200);
    }

    public function test_fail_customer_view_products(): void
    {
        $user = $this->user(Role::CUSTOMER);
        $response = $this->actingAs($user)->getJson(route('v1.admin.products.index'));
        $response->assertStatus(403);
    }

}
