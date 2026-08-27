<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            CategorySeeder::class,
            ProductSeeder::class,
        ]);

        User::query()->updateOrCreate(
            ['email' => 'admin@dtoucho.mx'],
            [
                'name' => 'Administración DTOUCHO',
                'password' => 'DtoAdmin2026!',
                'is_admin' => true,
            ],
        );

        User::query()->updateOrCreate(
            ['email' => 'cliente@dtoucho.mx'],
            [
                'name' => 'Cliente Demo',
                'password' => 'Cliente2026!',
                'is_admin' => false,
            ],
        );

        $this->call(OrderSeeder::class);
    }
}
