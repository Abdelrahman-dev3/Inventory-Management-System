<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inovice extends Model
{
    protected $fillable = [
        'customer_id',
        'discreption',
        'total_before_discount',
        'discount',
        'total_after_discount',
        'paid_status',
    ];

    public function customer()
    {
        return $this->belongsTo(Customers::class);
    }

    public function items()
{
    return $this->hasMany(Inovice_items::class, 'invoice_No');
}
}
