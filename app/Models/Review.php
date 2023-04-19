<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'comment',
        'star_rating',
        'can_update',
        'user_private',
        'count_like',
        'count_dislike',
        'is_block',
        'order_id',
        'user_id',
        'hotel_id',
        'type_room_id'
    ];

    protected $hidden = [
        'can_update',
        'user_private',
        'is_block',
        'order_id'
    ];

    public function images():HasMany 
    {
        return $this->hasMany(Image::class);
    }

    public function hotel():BelongsTo
    {
        return $this->belongsTo(Hotel::class);
    }

    public function typeRoom():BelongsTo
    {
        return $this->belongsTo(TypeRoom::class);
    }

    public function user():BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function likeReviews():BelongsToMany
    {
        return $this->belongsToMany(User::class, 'like_reviews', 'review_id', 'user_id')->withPivot('is_like');
    }

    public function reportReviews():BelongsToMany
    {
        return $this->belongsToMany(User::class, 'report_reviews', 'review_id', 'user_id');
    }
}
