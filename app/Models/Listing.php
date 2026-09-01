<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Listing extends Model
{
    protected $fillable=[
      'title','description','country','city','latitude','longitude','max_guests',
      'price_per_night','cover_image'
    ];

    public function user(): BelongsTo{
        return $this->belongsTo(User::class);
    }

    public function bookings(): HasMany{
        return $this->hasMany(Booking::class);
    }

    public function reviews(): HasMany{
        return $this->hasMany(Review::class);
    }

    public function favourites():HasMany{
        return $this->hasMany(Favourite::class);
    }

    public function photos():HasMany{
        return $this->hasMany(ListingPhoto::class);
    }
}
