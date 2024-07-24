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
        $data = [
            'name' => 'John',
            'lastname' => 'Doe',
            'email' => 'john.doe@example.com',
            'phone' => '3456789012',
            'birthday' => '1990-01-01',
            'password' => 'password',
            'password_confirmation' => 'password',
        ];
        $response =  $this->postJson(route('register'),$data);
        $this->assertDatabaseHas(User::class, ['email'=>$data['email']]);
        $response->assertStatus(200);
        $response->assertExactJson(['message'=>'OK']);
        $response->assertJsonCount(1);
    }

    public function test_fail_register_with_invalid_data(): void
    {
        $data = [
            'name' => 'Name',
            'lastname' => 'LastName',
            'email' => 'email@gmail.comm',
            'phone' => '123',
            'birthday' => '12345',
            'password' => 'password',
            'password_confirmation' => 'password',
        ];
        $response =  $this->postJson(route('register'),$data);
        $this->assertDatabaseMissing(User::class, ['email'=>$data['email']]);
        $response->assertStatus(422);
        $response->assertJsonValidationErrors([
                'phone'=>"The phone must be at least 10 digits",
                'birthday'=> "The birthday field must be a valid date."
            ]
        );
        $response->assertJsonIsObject('errors');
    }
}
