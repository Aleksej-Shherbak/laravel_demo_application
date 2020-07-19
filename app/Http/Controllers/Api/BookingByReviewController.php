<?php

namespace App\Http\Controllers\Api;

use App\Booking;
use App\Http\Controllers\Controller;
use App\Http\Resources\BookingByReviewShowResource;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BookingByReviewController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param string $reviewKey
     * @param \Illuminate\Http\Request $request
     * @return void
     */
    public function __invoke(string $reviewKey, Request $request)
    {
        if (!Str::isUuid($reviewKey)) {
            abort(404);
        }

        $res = Booking::findByReviewKey($reviewKey);

        return $res !== null ? new BookingByReviewShowResource($res) : abort(404);
    }
}
