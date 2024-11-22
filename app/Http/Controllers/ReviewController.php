<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produit;
use App\Models\Review;

class ReviewController extends Controller
{
    public function addReview(Request $request, $produitId)
    {
        $validated = $request->validate([
            'rating' => 'required|integer|between:1,5',
            'review' => 'nullable|string',
        ]);

        $produit = Produit::findOrFail($produitId);
        $user = auth()->user();

        $produit->reviews()->create([
            'user_id' => $user->id,
            'rating' => $validated['rating'],
            'review' => $validated['review'],
        ]);

        return redirect()->route('front.details', $produitId)->with('success', 'Votre avis a été soumis.');
    }

    public function deleteReview($reviewId)
    {
        $review = Review::findOrFail($reviewId);
        $review->delete();

        return redirect()->back()->with('success', 'Votre avis a été supprimé.');
    }

    public function showEditForm($reviewId)
    {
        $review = Review::findOrFail($reviewId);
        return view('reviews.edit', compact('review'));
    }

    public function editReview(Request $request, $reviewId)
    {
        $validated = $request->validate([
            'rating' => 'required|integer|between:1,5',
            'review' => 'nullable|string',
        ]);

        $review = Review::findOrFail($reviewId);
        $review->update($validated);

        return redirect()->back()->with('success', 'Votre avis a été modifié.');
    }
}
