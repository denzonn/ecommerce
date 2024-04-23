<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CategoryGeneralData;
use Illuminate\Http\Request;

class CategoryGeneralDataController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = CategoryGeneralData::all();

        return $this->sendResponse($data, 'Successfully get all category general data');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->all();

        CategoryGeneralData::create($data);

        return $this->sendResponse($data, 'Successfully create new category general data');
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
        $data = CategoryGeneralData::findOrFail($id);

        return $this->sendResponse($data, 'Successfully get data');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = $request->all();
        $categoryGeneralData = CategoryGeneralData::findOrFail($id);

        $categoryGeneralData->update($data);

        return $this->sendResponse($categoryGeneralData, 'Successfully update category general data');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $categoryGeneralData = CategoryGeneralData::findOrFail($id);

        $categoryGeneralData->delete();

        return $this->sendResponse($categoryGeneralData, 'Successfully delete category general data');
    }
}
