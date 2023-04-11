<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;


class TypeRoom extends Model
{
    protected $fillable = 
    [
        'name', 
        'description', 
        'price',
        'occupancy'
    ];

    public function hotel():BelongsTo
    {
        return $this->belongsTo(Hotel::class);
    }

    public function amenities(): BelongsToMany
    {
        return $this->belongsToMany(Amenity::class, 'type_room_amenity', 'type_room_id', 'amenity_id');
    }

    public function images():HasMany
    {
        return $this->hasMany(Image::class);
    }

    public function rooms():HasMany
    {
        return $this->hasMany(Room::class);
    }

    public static function boot() 
    {
        parent::boot();
        static::deleting(function($typeRoom) {
            $typeRoom->amenities()->detach();
            $typeRoom->rooms->each(function($room){
                $room->delete();
             });

            $typeRoom->images->each(function($image){
                $image->delete();
             });
        });
    }
}
