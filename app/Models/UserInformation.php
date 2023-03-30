<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations;

class UserInformation extends Model
{
    protected $fillable= [
        'first_name',
        'last_name',
        'phone_number',
        'date_of_birth',
        'email_contact'
    ];

    public function user(): Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
