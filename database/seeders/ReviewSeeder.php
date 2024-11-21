<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Review;

class ReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // rating and review
        $review1 = new Review();
        $review1->produit_id = 1;
        $review1->user_id = 1;
        $review1->rating = 5;
        $review1->review = 'Excellent produit';

        $review2 = new Review();
        $review2->produit_id = 2;
        $review2->user_id = 2;
        $review2->rating = 4;
        $review2->review = 'Bon produit';
    }
}
