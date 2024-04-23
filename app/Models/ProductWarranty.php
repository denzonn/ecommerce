<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductWarranty extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'warranty_summary',
        'warranty_service_type',
        'covered_in_warranty',
        'not_covered_in_warranty',
        'domestic_warranty',
    ];

    public function product(){
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
}
