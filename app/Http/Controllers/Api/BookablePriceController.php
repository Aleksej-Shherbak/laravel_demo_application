<?php

namespace App\Http\Controllers\Api;

use App\Bookable;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
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

        $days = (new Carbon($data['from']))
                ->diffInDays(new Carbon($data['to'])) + 1; // + 1 if somebody wants book for one day

        $totalPrice = $days * $bookable->price;

        return response()->json([
            'data' => [
                'total' => $totalPrice,

                // prepared on a future. Breakdown price is a feature like in Airbnb
                'breakdown' => [
                    $days => $bookable->price,
                ],
            ]
        ]);
    }
}
