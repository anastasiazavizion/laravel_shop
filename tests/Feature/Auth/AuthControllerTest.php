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

        $response = $this->post(route('login'), [
            'email' => $user->email,
            'password' => $password,
        ]);

        $response->assertStatus(200);
        $response->assertExactJson(['message' => 'Authenticated']);
        $response->assertJsonCount(1);
        $this->assertAuthenticatedAs($user);
    }

    public function test_fail_login_with_not_present_data(): void
    {
        $data = [
            'email'=>'test@gmail.com',
            'password'=>'password'
        ];
        $this->assertDatabaseMissing(User::class, ['email' => $data['email']]);
        $response = $this->post(route('login'), $data);
        $response->assertExactJson(['message' => 'Unauthorized']);
        $response->assertJsonCount(1);
        $response->assertUnauthorized();
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

        $response = $this->post(route('login'), $data);
        $response->assertStatus(422); //with post return 302 - redirect

        $response->assertJsonValidationErrors(['email', 'password']);
        $response->assertJsonIsObject('errors');
    }

    public function test_success_admin_view_products(): void
    {
        $user = $this->user();
        $response = $this->actingAs($user)->getJson(route('admin.products.index'));
        $response->assertStatus(200);
    }

    public function test_success_moderator_view_products(): void
    {
        $user = $this->user(Role::MODERATOR);
        $response = $this->actingAs($user)->getJson(route('admin.products.index'));
        $response->assertStatus(200);
    }

    public function test_fail_customer_view_products(): void
    {
        $user = $this->user(Role::CUSTOMER);
        $response = $this->actingAs($user)->getJson(route('admin.products.index'));
        $response->assertStatus(403);
    }

}
