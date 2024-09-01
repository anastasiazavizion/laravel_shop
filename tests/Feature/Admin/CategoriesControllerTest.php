<?php

namespace Tests\Feature\Admin;

use App\Enum\Role;
use App\Models\Category;
use Tests\Feature\Traits\SetupTrait;
use Tests\TestCase;

class CategoriesControllerTest extends TestCase
{
   use SetupTrait;

    public function test_success_view_categories_as_admin()
    {
        $categories = Category::factory(3)->create();
        $response = $this->actingAs($this->user())
            ->getJson(route('v1.admin.categories.index'));
        $response->assertSuccessful();
        $categories->map(function ($category) use ($response){
            $response->assertJsonFragment(['name' => $category->name]);
        });
    }

    public function test_success_view_categories_as_moderator()
    {
        $categories = Category::factory(3)->create();
        $response = $this->actingAs($this->user(Role::MODERATOR))
            ->getJson(route('v1.admin.categories.index'));
        $response->assertSuccessful();
        $categories->map(function ($category) use ($response){
            $response->assertJsonFragment(['name' => $category->name]);
        });
    }

    public function test_fail_view_categories_as_customer()
    {
        Category::factory(3)->create();
        $response = $this->actingAs($this->user(Role::CUSTOMER))
            ->getJson(route('v1.admin.categories.index'));
        $response->assertForbidden();
    }

    public function test_success_create_category_with_valid_data_as_admin()
    {
        $data = Category::factory()->makeOne()->toArray();
        $this->assertDatabaseMissing(Category::class, [
            'name' => $data['name']
        ]);
        $response = $this->actingAs($this->user())
            ->postJson(route('v1.admin.categories.store'), $data);
        $response->assertStatus(200);
        $response->assertJsonFragment(['message' => 'Category '.$data['name'].' was created']);
        $this->assertDatabaseHas(Category::class, [
            'name' => $data['name']
        ]);
    }

    public function test_fail_create_category_with_valid_data_as_customer()
    {
        $data = Category::factory()->makeOne()->toArray();
        $this->assertDatabaseMissing(Category::class, [
            'name' => $data['name']
        ]);
        $response = $this->actingAs($this->user(Role::CUSTOMER))
            ->postJson(route('v1.admin.categories.store'), $data);
        $response->assertForbidden();
    }

    public function test_fail_create_category_with_invalid_data_as_admin()
    {
        $data = [
            'name'=>'n',
            'parent_id'=>12345
        ];
        $this->assertDatabaseMissing(Category::class, ['name'=>$data['name']]);
        $response = $this->actingAs($this->user())
            ->postJson(route('v1.admin.categories.store'), $data);
        $response->assertJsonValidationErrors(['name', 'parent_id']);
        $response->assertStatus(422);
    }


    public function test_success_update_category_with_valid_data_as_admin()
    {
        $newName = 'updated';
        $category = Category::factory()->createOne();
        $data = array_merge($category->toArray(), ['name' => $newName]);
        $this->assertDatabaseHas(Category::class, [
            'name' => $category->name,
            'slug' => $category->slug
        ]);
        $this->assertDatabaseMissing(Category::class, [
            'name' => $newName,
            'slug' => $newName
        ]);
        $response = $this->actingAs($this->user())
            ->putJson(route('v1.admin.categories.update', $category), $data);

        $this->assertDatabaseHas(Category::class, [
            'name' => $newName,
            'slug' => $newName
        ]);
        $this->assertDatabaseMissing(Category::class, [
            'name' => $category->name,
            'slug' => $category->slug
        ]);
        $response->assertStatus(200);
        $response->assertJsonFragment(['message' => "Category $newName was updated"]);
    }

    public function test_fail_update_category_with_invalid_data_as_admin()
    {
        $newName = 'u';
        $category = Category::factory()->createOne();
        $data = array_merge($category->toArray(), ['name' => $newName]);
        $response = $this->actingAs($this->user())
            ->putJson(route('v1.admin.categories.update', $category), $data);

        $this->assertDatabaseMissing(Category::class, [
            'name' => $newName,
            'slug' => $newName
        ]);
        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['name']);
    }

    public function test_success_remove_category_as_admin()
    {
        $category = Category::factory()->create();
        $name = $category->name;
        $this->assertDatabaseHas(Category::class, [
            'id' => $category->id
        ]);
        $response =  $this->actingAs($this->user())
            ->delete(route('v1.admin.categories.destroy', $category));
        $this->assertDatabaseMissing(Category::class, [
            'id' => $category->id
        ]);
        $response->assertStatus(200);
        $response->assertJsonFragment(['message' => "Category $name was removed"]);
    }

    public function test_fail_remove_category_as_customer()
    {
        $category = Category::factory()->create();
        $this->assertDatabaseHas(Category::class, [
            'id' => $category->id
        ]);
        $response =  $this->actingAs($this->user(Role::CUSTOMER))
            ->delete(route('v1.admin.categories.destroy', $category));
        $response->assertForbidden();
    }

    public function test_success_remove_category_as_admin_and_set_null_to_child()
    {
        $category = Category::factory()->createOne();
        $name = $category->name;
        $child = Category::factory()->createOne(['parent_id' => $category->id]);
        $this->assertDatabaseHas(Category::class, [
            'id' => $category->id
        ]);
        $this->assertDatabaseHas(Category::class, [
            'id' => $child->id
        ]);
        $this->assertEquals($child->parent_id, $category->id);
        $response =  $this->actingAs($this->user())
            ->delete(route('v1.admin.categories.destroy', $category));
        $this->assertDatabaseMissing(Category::class, [
            'id' => $category->id
        ]);
        $response->assertStatus(200);
        $response->assertJsonFragment(['message' => "Category $name was removed"]);
        $child->refresh();
        $this->assertNull($child->parent_id);
    }

}
