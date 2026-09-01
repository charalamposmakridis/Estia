<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ListingPhoto extends Model
{
    protected $fillable=[
      'listing_id','photo_path','is_main'
    ];

    protected $casts=[
      'is_main'=>'boolean'
    ];

    public function listing():BelongsTo{
        return $this->belongsTo(Listing::class);
    }
}
