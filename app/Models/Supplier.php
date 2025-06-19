<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
        protected $fillable = [
        'supplier_name',
        'supplier_mobile',
        'supplier_email',
        'supplier_address',
    ];
}