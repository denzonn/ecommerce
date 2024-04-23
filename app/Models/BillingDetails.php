<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BillingDetails extends Model
{
    use HasFactory;

    protected $fillable = [
        'billing_id',
        'product_id',
        'user_id',
        'purchase_price'
    ];

    public function billing(){
        return $this->belongsTo(Billing::class, 'billing_id', 'id');
    }

    public function product(){
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    public function user(){
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
