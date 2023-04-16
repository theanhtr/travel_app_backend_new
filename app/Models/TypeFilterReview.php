<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypeFilterReview extends Model
{
    use HasFactory;
    protected $fill_able = ['name'];

    public $timestamps = false;
}
