<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductAdditionalInformation;
use App\Models\ProductDescription;
use App\Models\ProductDimension;
use App\Models\ProductPhotos;
use App\Models\ProductVariant;
use App\Models\ProductWarranty;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Product::all();

        $data->transform(function ($product) {
            $product->tags = json_decode($product->tags);
            return $product;
        });

        return $this->sendResponse($data, 'Successfully get data product');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $tags = json_encode($request['tags']);

        $data['slug'] = \Str::slug($request->name);

        $this->validate($request, [
            'photo.*' =>'required|image|mimes:png,jpg|max:5120',
        ]);

        $product = Product::create([
            'category_id' => $data['category_id'],
            'type_id' => $data['type_id'],
            'sku' => $data['sku'],
            'name' => $data['name'],
            'slug' => $data['slug'],
            'price' => $data['price'],
            'tags' => $tags,
        ]);

        // foreach ($data['variant'] as $item) {
        //     $variant = ProductVariant::create([
        //         "product_id" => $product->id,
        //         "color" => $item['color'],
        //     ]);
        // }

        $description = ProductDescription::create([
            'product_id' => $product->id,
            'description' => $data['description'],
            'detail_description' => $data['detail_description'],
        ]);

        $dimension = ProductDimension::create([
           "product_id" => $product->id,
           "width" => $data['width'],
           "height" => $data['height'],
           "weight" => $data['weight'],
           "depth" => $data['depth'],
        ]);

        // foreach($data['productAdditional'] as $item) {
        //     $additional = ProductAdditionalInformation::create([
        //         'product_id' => $product->id,
        //         'category_general_data_id' => $item['category_general_data_id'],
        //         'value' => $item['value'],
        //     ]);
        // }

        if($request->hasFile('photo')){
            foreach($request->file('photo') as $image){
                $extension = $image->getClientOriginalExtension();

                $random = substr(str_shuffle('0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 10);

                $file_name = $random . "." . $extension;

                $image->storeAs('product', $file_name, 'public');

                ProductPhotos::create([
                    'product_id' => $product->id,
                    'photo' => $file_name,
                ]);
            }
        }

        $warranty = ProductWarranty::create([
            'product_id' => $product->id,
            'warranty_summary' => $data['warranty_summary'],
            'warranty_service_type' => $data['warranty_service_type'],
            'covered_in_warranty' => $data['covered_in_warranty'],
            'not_covered_in_warranty' => $data['not_covered_in_warranty'],
            'domestic_warranty' => $data['domestic_warranty'],
        ]);

        $allData = [
            'product' => $product,
            'description' => $description,
            'dimension' => $dimension,
            // 'additional_information' => $additional,
            'warranty' => $warranty
        ];

        return $this->sendResponse($allData, 'Successfully create a new product');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $slug)
    {
        $data = Product::where('slug', $slug)->first();
        $data['tags'] = json_decode($data['tags']);

        return $this->sendResponse($data, 'Successfully get product');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // $data = $request->all();
        // $tags = json_encode($request['tags']);

        // $data['slug'] = \Str::slug($request->name);

        // $this->validate($request, [
        //     'photo.*' =>'required|image|mimes:png,jpg|max:5120',
        // ]);

        // $product = Product::findOrFail($id);
        // $product->update([
        //     'category_id' => $data['category_id'],
        //     'type_id' => $data['type_id'],
        //    'sku' => $data['sku'],
        //     'name' => $data['name'],
        //    'slug' => $data['slug'],
        //     'price' => $data['price'],
        //     'tags' => $tags,
        // ]);

        // $description = ProductDescription::where('product_id', $id)->first();
        // $description->update([
        //     'description' => $data['description'],
        //     'detail_description' => $data['detail_description'],
        // ]);

        // $dimension = ProductDimension::where('product_id', $id)->first();
        // $dimension->update([
        //     "width" => $data['width'],
        //     "height" => $data['height'],
        //     "weight" => $data['weight'],
        //     "depth" => $data['depth'],
        // ]);

        // if($request->hasFile('photo')){
        //     foreach($request->file('photo') as $image){
        //         $extension = $image->getClientOriginalExtension();

        //         $random = substr(str_shuffle('0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 10);

        //         $file_name = $random . "." . $extension;

        //         $image->storeAs('product', $file_name, 'public');

        //         ProductPhotos::create([
        //             'product_id' => $product->id,
        //             'photo' => $file_name,
        //         ]);
        //     }
        // }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = Product::findOrFail($id);
        $photos = $product->photo;

        if($photos) {
            foreach($photos as $photo) {
                Storage::disk('public')->delete('product/'. $photo->photo);
            }
        }

        $product->delete();

        return $this->sendResponse($product, 'Successfully delete product');
    }
}
