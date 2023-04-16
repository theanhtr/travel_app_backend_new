<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations;
class Image extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'path',
        'role_image_id',
        'hotel_id',
        'type_room_id', 
        'review_id',
        'user_id'
    ];

    public function user(): Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function roleImage():Relations\BelongsTo
    {
        return $this->belongsTo(RoleImage::class);    
    }

    public function hotel(): Relations\BelongsTo
    {
        return $this->belongsTo(Hotel::class);
    }

    public function typeRoom(): Relations\BelongsTo
    {
        return $this->belongsTo(TypeRoom::class);
    }

    public function review(): Relations\BelongsTo
    {
        return $this->belongsTo(Review::class);
    }
}
