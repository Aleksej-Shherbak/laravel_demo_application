<?php

namespace App;

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
}
