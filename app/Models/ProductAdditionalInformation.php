<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductAdditionalInformation extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'category_general_data_id',
        'value',
    ];

    public function product(){
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    public function category_general_data(){
        return $this->belongsTo(CategoryGeneralData::class, 'category_general_data_id', 'id');
    }
}
