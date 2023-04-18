<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Province extends Model
{
    public $timestamps = false;
    protected $fillable = ['name'];

    public function addresses():HasMany
    {
        return $this->hasMany(Address::class);
    }

    public function districts(): HasMany
    {
        return $this->hasMany(District::class);
    }

    public function popularDestination():HasOne 
    {
        return $this->hasOne(PopularDestination::class);
    }
}
