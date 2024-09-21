<?php

use Illuminate\Database\Migrations\Migration;
use App\Models\User;
use App\Enum\Role;
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $user = User::role(Role::ADMIN->value)->first();
        $user->update(['email'=>env('MAIL_FROM_ADDRESS','admin@gmail.com')]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
