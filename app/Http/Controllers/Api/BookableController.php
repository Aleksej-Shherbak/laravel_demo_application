<?php

namespace App\Http\Controllers\Api;

use App\Bookable;
use App\Http\Controllers\Controller;
use App\Http\Resources\BookableIndexResource;
use App\Http\Resources\BookableShowResource;
use Illuminate\Http\Request;

class BookableController extends Controller
{
    public function index(Request $request)
    {
        return BookableIndexResource::collection(Bookable::all());
    }

    public function show(int $id)
    {
        return new BookableShowResource(Bookable::findOrFail($id));
    }
}
