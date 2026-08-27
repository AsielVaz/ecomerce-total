<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            'Tecnología' => 'Innovación para trabajar, crear y disfrutar todos los días.',
            'Hogar' => 'Objetos funcionales que hacen más simple y bonito tu espacio.',
            'Moda' => 'Esenciales contemporáneos para un estilo sin esfuerzo.',
            'Belleza' => 'Cuidado personal, bienestar y rutinas que se sienten bien.',
            'Deportes' => 'Equipo para moverte, entrenar y llegar un poco más lejos.',
            'Gaming' => 'Accesorios y tecnología para una experiencia de juego inmersiva.',
        ];

        foreach ($categories as $name => $description) {
            Category::query()->updateOrCreate(
                ['slug' => Str::slug($name)],
                ['name' => $name, 'description' => $description, 'is_active' => true],
            );
        }
    }
}
