<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductDimension extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'width',
        'height',
        'depth',
        'weight',
    ];

    public function product(){
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
}
