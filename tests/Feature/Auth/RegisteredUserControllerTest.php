<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegisteredUserControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     */
    public function test_success_register_with_valid_data(): void
    {
        $data = [...$this->userPasswordData(), ...User::factory()->make()->toArray()];
        $response =  $this->post(route('register'),$data);
        $this->assertDatabaseHas(User::class, ['email'=>$data['email']]);
        $response->assertStatus(200);
        $response->assertExactJson(['message'=>'OK']);
        $response->assertJsonCount(1);
    }

    public function test_fail_register_with_invalid_data(): void
    {
        $data = [...$this->userPasswordData(), ...User::factory([
            'phone' => '123',
            'birthday' => '12345',
        ])->make()->toArray()];
        $response =  $this->post(route('register'),$data);
        $this->assertDatabaseMissing(User::class, ['email'=>$data['email']]);
        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['phone','birthday']);
        $response->assertJsonIsObject('errors');
    }

    private function userPasswordData()
    {
        return ['password'=>'password', 'password_confirmation'=>'password'];

    }
}
