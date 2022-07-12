<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        User::factory()->create([
            'name' => 'user1',
            'email' => 'user1@mail.ru',
            'password' => bcrypt('1234'),
        ]);

        User::factory()->create([
            'name' => 'user2',
            'email' => 'user2@mail.ru',
            'password' => bcrypt('1234'),
        ]);

        $this->call([
            StorageSeeder::class,
        ]);
    }
}
