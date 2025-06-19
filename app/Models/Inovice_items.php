<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inovice_items extends Model
{
    protected $fillable = [
        'product_id',
        'category_id',
        'quantity',
        'price',
        'total_all',
        'invoice_No',
    ];
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}

