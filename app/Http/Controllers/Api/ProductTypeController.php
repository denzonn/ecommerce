<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ProductType;
use Illuminate\Http\Request;

class ProductTypeController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = ProductType::all();

        return $this->sendResponse($data, 'Successfully get data');
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

        ProductType::create($data);

        return $this->sendResponse($data, 'Successfully create new product type');
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
    public function edit(string $id)
    {
        $data = ProductType::findOrFail($id);

        return $this->sendResponse($data, 'Successfully get data');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = $request->all();
        $productType = ProductType::findOrFail($id);

        $productType->update($data);

        return $this->sendResponse($productType, 'Successfully update product type');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = ProductType::findOrFail($id);

        $data->delete();

        return $this->sendResponse($data, 'Successfully delete product type');
    }
}
