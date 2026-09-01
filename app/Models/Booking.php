<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Booking extends Model
{
    protected $fillable=[
      'user_id','listing_id','check_in','check_out','total_price','status'
    ];

    protected $casts=[
      'check_in'=>'datetime',
      'check_out'=>'datetime',
    ];

    public function listing(): BelongsTo{
        return $this->belongsTo(Listing::class);
    }

    public function user(): BelongsTo{
        return $this->belongsTo(User::class);
    }

}
