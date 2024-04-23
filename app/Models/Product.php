<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'type_id',
        'sku',
        'name',
        'slug',
        'price',
        'discount_price',
        'tags',
    ];

    protected $with = ['category', 'reviews', 'description', 'dimension', 'additionalInformation', 'photo', 'warranty'];

    public function category(){
        return $this->belongsTo(CategoryProduct::class, 'category_id', 'id');
    }

    public function reviews(){
        return $this->hasMany(ProductReview::class);
    }

    public function description(){
        return $this->hasMany(ProductDescription::class);
    }

    public function dimension(){
        return $this->hasMany(ProductDimension::class);
    }

    public function additionalInformation(){
        return $this->hasMany(ProductAdditionalInformation::class);
    }

    public function photo(){
        return $this->hasMany(ProductPhotos::class);
    }

    public function warranty(){
        return $this->hasMany(ProductWarranty::class);
    }
}
