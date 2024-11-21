<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::create(['name' => 'Électronique']);
        Category::create(['name' => 'Vêtements']);
        Category::create(['name' => 'Maison']);
        Category::create(['name' => 'Jouets']);
        Category::create(['name' => 'Livres']);
        Category::create(['name' => 'Informatique']);
        Category::create(['name' => 'Jeux vidéo']);
        Category::create(['name' => 'Musique']);
        Category::create(['name' => 'Films']);
        Category::create(['name' => 'Bijoux']);
        Category::create(['name' => 'Sports']);
        Category::create(['name' => 'Automobile']);
        Category::create(['name' => 'Bricolage']);
        Category::create(['name' => 'Jardinage']);
        Category::create(['name' => 'Cuisine']);
        Category::create(['name' => 'Santé']);
        Category::create(['name' => 'Beauté']);
        Category::create(['name' => 'Épicerie']);
        Category::create(['name' => 'Animaux']);
        Category::create(['name' => 'Bébés']);
        Category::create(['name' => 'Enfants']);
        Category::create(['name' => 'Adolescents']);
        Category::create(['name' => 'Adultes']);
        Category::create(['name' => 'Personnes âgées']);
    }
}
