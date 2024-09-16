<?php
namespace Tests\Feature\Traits;

use App\Enum\Role;
use App\Models\User;
use Database\Seeders\CategoryProductSeeder;
use Database\Seeders\PermissionsAndRolesSeeder;
use Database\Seeders\UserSeeder;
use \Illuminate\Foundation\Testing\RefreshDatabase;

trait SetupTrait{

    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
    }

    protected function afterRefreshingDatabase()
    {
        $this->seed(CategoryProductSeeder::class);
        $this->seed(PermissionsAndRolesSeeder::class);
        $this->seed(UserSeeder::class);
    }

    protected function user(Role $role = Role::ADMIN): User
    {
        return User::role($role->value)->firstOrFail();
    }

}
