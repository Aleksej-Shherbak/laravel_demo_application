<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class Bookable
 * @package App
 * @property integer $id
 * @property integer $price
 * @property string $title
 * @property string $description
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 *
 */
class Bookable extends Model
{
    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }

    public function availableFor($from, $to): bool
    {
        return $this->bookings()->betweenDates($from, $to)->count() === 0;
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function priceFor($from, $to): PriceDto
    {
        $days = (new Carbon($from))
                ->diffInDays(new Carbon($to)) + 1; // + 1 if somebody wants book for one day

        $totalPrice = $days * $this->price;

        return new PriceDto($totalPrice, [
            $days => $this->price,
        ]);
    }
}
