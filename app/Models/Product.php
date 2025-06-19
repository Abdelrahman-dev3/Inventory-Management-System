<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'product_name',
        'supplier_id',
        'unit_id',
        'category_id',
    ];
    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }
    
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    
    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }
}
