<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Laravel\Scout\Searchable;

class Hotel extends Model
{
    use Searchable;

    public function searchableAs()
    {
        return 'hotels_name_idx';
    }

    protected $fillable = 
    [
        'name', 
        'description', 
        'min_price',
        'max_price',
        'address_id'
    ];

    public function user():BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function address():BelongsTo
    {
        return $this->belongsTo(Address::class);
    }

    public function images():HasMany
    {
        return $this->hasMany(Image::class);
    }

    public function amenities(): BelongsToMany
    {
        return $this->belongsToMany(Amenity::class, 'amenity_hotel', 'hotel_id', 'amenity_id');
    }

    public function typeRooms(): HasMany
    {
        return $this->hasMany(TypeRoom::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public static function boot() 
    {
        parent::boot();
        static::deleting(function($hotel) {
            $hotel->amenities()->detach();
            $hotel->typeRooms->each(function($typeRoom){
                $typeRoom->delete();
             });
            
             $hotel->images->each(function($image){
                $image->delete();
             });
        });
    }
}
