<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    //
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'name',
        'branch',
        'contact_number',
        'date',
        'concern',
        'message'
    ];
}
