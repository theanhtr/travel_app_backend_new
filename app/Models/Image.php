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
        'name',
        'size',
        'type',
        'deleted_at',
    ];

    public function user(): Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
