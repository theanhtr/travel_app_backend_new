<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class RoleImage extends Model
{
    public $timestamps = false;
    protected $fillable = ['name'];

    public function images():HasMany
    {
        return $this->hasMany(Image::class);
    }
}
