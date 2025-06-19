<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Purchase_item extends Model
{
    protected $fillable = [
        'purchase_id',
        'category_id',
        'product_id',
        'quantity',
        'unit_price',
        'total_price',
    ];
    
    public function purchase()
    {
        return $this->belongsTo(Purchase::class);
    }
    
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
