<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Str;

/**
 * Class Booking
 * @package App
 * @property integer $id
 * @property \Illuminate\Support\Carbon $from
 * @property \Illuminate\Support\Carbon $to
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property integer $bookable_id
 * @property string $review_key // uuid for a new possible review for this Booking
 */
class Booking extends Model
{
    protected $fillable = ['from', 'to'];

    public function bookable(): BelongsTo
    {
        return $this->belongsTo(Bookable::class);
    }

    public function review() : HasOne
    {
        return $this->hasOne(Review::class);
    }

    public function scopeBetweenDates(Builder $query, $from, $to)
    {
        return $query->where('to', '>=', $from)
            ->where('from', '<=', $to);
    }

    /**
     * @param string $reviewKey
     * @return Booking|null
     */
    public static function findByReviewKey(string $reviewKey): ?Booking
    {
        return static::with('bookable')->where('review_key', $reviewKey)->get()->first();
    }

    protected static function boot(): void
    {
        parent::boot();
        // generate uuid after creating a new one Booking
        static::creating(function (Booking $booking) {
            $booking->review_key = Str::uuid();
        });
    }
}
