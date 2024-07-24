<?php

namespace Tests\Feature\Admin;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\Feature\Traits\SetupTrait;
use Tests\TestCase;

class CategoriesControllerTest extends TestCase
{
    use SetupTrait;

    /**
     * A basic feature test example.
     */
    public function test_index(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
