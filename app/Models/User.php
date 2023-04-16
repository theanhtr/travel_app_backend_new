<?php

namespace App\Models;

use App\Traits\HttpResponse;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, HttpResponse;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     * Summary of fillable
     * @var array
     */
    protected $fillable = [
        'email',
        'password',
        'role_id'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function information(): HasOne 
    {
        return $this->hasOne(UserInformation::class);
    }

    public function role():BelongsTo
    {
        return $this->belongsTo(Role::class);    
    }

    public function images(): HasMany
    {
        return $this->hasMany(Image::class);
    }

    public function hotel(): HasOne
    {
        return $this->hasOne(Hotel::class);
    }

    
    public function orders():HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function interactReivews():BelongsToMany
    {
        return $this->belongsToMany(Review::class, 'interact_reivews', 'user_id', 'review_id');
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }
}
