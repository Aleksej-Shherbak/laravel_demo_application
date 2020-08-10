<?php

namespace App\Http\Controllers\Api;

use App\Address;
use App\Bookable;
use App\Booking;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    /**
     * Checkout endpoint action.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Support\Collection
     */
    public function __invoke(Request $request)
    {
        $data = $request->validate([
            'bookings' => 'required|array|min:1',
            'bookings.*.bookable_id' => 'required|exists:bookables,id',
            'bookings.*.from' => 'required|date|after_or_equal:today',
            'bookings.*.to' => 'required|date|after_or_equal:bookings.*.from',

            'customer.first_name' => 'required|min:2|max:100',
            'customer.last_name' => 'required|min:2|max:100',
            'customer.email' => 'required|email',
            'customer.street' => 'required|min:3|max:200',
            'customer.city' => 'required|min:3|max:100',
            'customer.country' => 'required|min:3|max:100',
            'customer.state' => 'required|min:3|max:50',
            'customer.zip' => 'required|min:2|max:500',
        ]);

        // without array_merge the data will contains only last fields (last in validation)
        $data = array_merge($data, $request->validate([
            'bookings.*' => [
                'required',
                function ($attribute, $value, $fail) {
                    $bookable = Bookable::findOrFail($value['bookable_id']);

                    if (!$bookable->availableFor($value['from'], $value['to'])) {
                        $fail('The object is not available for given dates');
                    }
                }
            ],
        ]));

        $bookingsDate = $data['bookings'];
        $addressDate = $data['customer'];

        /**
         * @var Bookable $bookable;
         */
        $bookings = collect($bookingsDate)->map(function ($bookingsDate) use ($addressDate) {
            $bookable = Bookable::findOrFail($bookingsDate['bookable_id']);
            $booking = new Booking();
            $booking->from = $bookingsDate['from'];
            $booking->to = $bookingsDate['to'];
            $booking->price = $bookable->priceFor($booking->from, $booking->to)->total;
            $booking->bookable()->associate($bookable);

            $booking->address()->associate(Address::create($addressDate));

            $booking->save();

            return $booking;
        });

        return $bookings;

    }
}
