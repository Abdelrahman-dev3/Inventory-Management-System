<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    protected $fillable = [
        'supplier_id',
        'category_id',
        'product_id',
        'in_qty',
        'out_qty',
        'stock',
    ]; 
        public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

        protected $appends = ['stock'];

    public function getStockAttribute()
    {
        return $this->in_qty - $this->out_qty;
    }


}
