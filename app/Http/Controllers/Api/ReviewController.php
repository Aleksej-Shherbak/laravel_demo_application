<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ReviewResource;
use App\Review;
use Illuminate\Support\Str;

class ReviewController extends Controller
{
    public function show($id)
    {
        if (!Str::isUuid($id)) {
            abort(404);
        }

        return new ReviewResource(Review::findOrFail($id));
    }
}
