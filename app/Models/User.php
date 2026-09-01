<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'email', 'password','is_host'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_host'=>'boolean',
        ];
    }

    public function listings(): HasMany{
        return $this->hasMany(Listing::class);
    }

    public function bookings(): HasMany{
        return $this->hasMany(Booking::class);
    }

    public function reviews(): HasMany{
        return $this->hasMany(Review::class);
    }

    public function favourites(): BelongsToMany
    {
        return $this->belongsToMany(Listing::class, 'favourites', 'user_id', 'listing_id');
    }

}
