<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class PopularDestination extends Model
{
    use HasFactory;

    protected $fillable = [
        'province_id',
        'image_path'
    ];

    public function province():BelongsTo {
        return $this->belongsTo(Province::class);
    }
}
