<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Amenity extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'font_awesome_class',
        'description',
        'role_amenity_id'
    ];

    public function roleAmenity(): BelongsTo
    {
        return $this->belongsTo(RoleAmenity::class);
    }

    public function hotels(): BelongsToMany
    {
        return $this->belongsToMany(Amenity::class, 'amenity_hotel', 'amenity_id', 'hotel_id');
    }

    public function rooms(): BelongsToMany
    {
        return $this->belongsToMany(Room::class);
    }
}
