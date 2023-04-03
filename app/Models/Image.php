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
        'hotel_id'
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
}
