<?php

namespace App\Http\Controllers\Api;

use App\Bookable;
use App\Http\Controllers\Controller;
use App\Http\Resources\BookableReviewIndexResource;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BookableReviewController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param string $id
     * @param Request $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function __invoke(string $id, Request $request)
    {
        /**
         * @var Bookable $bookable
         */
        $bookable = Bookable::findOrFail($id);

        return BookableReviewIndexResource::collection($bookable->reviews()->latest()->get());
    }
}
