<?php

namespace App\Http\Controllers\Api;

use App\Booking;
use App\Http\Controllers\Controller;
use App\Http\Resources\ReviewResource;
use App\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class ReviewController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'id' => 'required|uuid|unique:reviews',
            'content' => 'required|min:2',
            'rating' => 'required|in:0,1,2,3,4,5',
        ]);

        $booking = Booking::findByReviewKey($data['id']);

        if ($booking === null) {
            abort(404);
        }

        $booking->review_key = null;
        $booking->save();

        /**
         * @var Review $review
         */
        $review = Review::make($data);
        $review->booking_id = $booking->id;
        $review->bookable_id = $booking->bookable_id;
        $review->save();

        return new ReviewResource($review);
    }

    public function show($id)
    {
        if (!Str::isUuid($id)) {
            abort(404);
        }

        return new ReviewResource(Review::findOrFail($id));
    }
}
