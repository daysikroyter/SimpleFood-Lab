<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class CategoryFactory extends Factory
{
    protected $model = Category::class;

    public function definition(): array
    {
        $title = fake()->unique()->randomElement(['Pizza', 'Burgers', 'Salads', 'Drinks', 'Desserts', 'Sushi', 'Pasta', 'Seafood']);
        
        return [
            'title' => $title,
            'slug' => strtolower($title),
            'icon' => strtolower($title),
        ];
    }
}
