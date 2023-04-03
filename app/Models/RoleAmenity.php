<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class RoleAmenity extends Model
{
    public $timestamps = false;
    protected $fillable = ['name'];

    public function amenities():HasMany
    {
        return $this->hasMany(Amenity::class);
    }
}
