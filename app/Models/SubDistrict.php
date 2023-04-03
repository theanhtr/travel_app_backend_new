<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SubDistrict extends Model
{
    public $timestamps = false;
    protected $fillable = ['name', 'district_id'];

    public function addresses():HasMany
    {
        return $this->hasMany(Address::class);
    }

    public function district(): BelongsTo
    {
        return $this->belongsTo(District::class);
    }
}
