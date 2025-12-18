<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductReview;
use Illuminate\Http\Request;

class ProductReviewController extends Controller
{
    public function index($productId)
    {
        $reviews = ProductReview::where('product_id', $productId)
            ->with('user')
            ->latest()
            ->paginate(10);

        return response()->json([
            'success' => true,
            'data' => $reviews,
        ]);
    }

    public function store(Request $request, $productId)
    {
        $product = Product::findOrFail($productId);

        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:1000',
        ]);

        $review = ProductReview::create([
            'product_id' => $product->id,
            'user_id' => $request->user()->id,
            'rating' => $validated['rating'],
            'comment' => $validated['comment'],
        ]);

        return response()->json([
            'success' => true,
            'data' => $review,
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $review = ProductReview::findOrFail($id);

        // Check if user owns this review
        if ($review->user_id !== $request->user()->id) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized',
            ], 403);
        }

        $validated = $request->validate([
            'rating' => 'sometimes|integer|min:1|max:5',
            'comment' => 'sometimes|string|max:1000',
        ]);

        $review->update($validated);

        return response()->json([
            'success' => true,
            'data' => $review,
        ]);
    }

    public function destroy(Request $request, $id)
    {
        $review = ProductReview::findOrFail($id);

        // Check if user owns this review or is admin
        if ($review->user_id !== $request->user()->id && !$request->user()->is_admin) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized',
            ], 403);
        }

        $review->delete();

        return response()->json([
            'success' => true,
            'message' => 'Review deleted successfully',
        ]);
    }
}
