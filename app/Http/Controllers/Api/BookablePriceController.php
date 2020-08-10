<?php

namespace App\Http\Controllers\Api;

use App\Bookable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BookablePriceController extends Controller
{
    /**
     * Calculate total price of a bookable for a period.
     *
     * @param integer $id
     * @param \Illuminate\Http\Request $request
     * @return void
     * @throws \Exception
     */
    public function __invoke($id, Request $request)
    {
        $data = $request->validate([
            'from' => 'required|date_format:Y-m-d',
            'to' => 'required|date_format:Y-m-d|after_or_equal:from',
        ]);

        /**
         * @var Bookable $bookable ;
         */
        $bookable = Bookable::findOrFail($id);

        return response()->json([
            'data' => $bookable->priceFor($data['from'], $data['to'])
        ]);
    }
}
