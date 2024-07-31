<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(10)->create();
        Role::create(['name' => 'admin']);
        Role::create(['name' => 'user']);

        $user =User::factory()->create([
            'first_name' => 'ibrahim',
            'last_name' => 'admin',
            'email' => 'a@a.a',
            'password' => Hash::make('a'),
        ]);
        $user->assignRole('admin');
        $user->assignRole('user');

        Product::factory(30)->create();
    }
}
