<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customers extends Model
{
        protected $fillable = [
        'customer_name',
        'customer_image',
        'email',
        'address',
    ];
}