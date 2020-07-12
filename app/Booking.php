<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Booking
 * @package App
 * @property integer $id
 * @property \DateTime $from
 * @property \DateTime $to
 * @property \DateTime $created_at
 * @property \DateTime $updated_at
 * @property integer $bookable_id
 */
class Booking extends Model
{
    protected  $fillable = ['from', 'to'];

    public function bookable()
    {
        $this->belongsTo(Bookable::class);
    }

    public function review()
    {
        return $this->hasOne(Review::class);
    }

    public function scopeBetweenDates(Builder $query, $from, $to) {
        return $query->where('to', '>=', $from)
            ->where('from', '<=', $to);
    }
}
