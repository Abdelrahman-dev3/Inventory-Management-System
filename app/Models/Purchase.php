<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
        protected $fillable = [
        'supplier_id',
        'total_amount',
        'status',
        'description'
    ];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }
    public function purchase()
    {
        return $this->belongsTo(Purchase_item::class);
    }
}
