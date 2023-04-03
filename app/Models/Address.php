<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Address extends Model
{
    public $timestamps = false;
    protected $fillable = ['specific_address', 'province_id', 'district_id', 'sub_district_id'];

    public function hotels():HasMany
    {
        return $this->hasMany(Hotel::class);
    }
}
