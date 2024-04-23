<?php

namespace App\Http\Controllers\Api;

use App\Models\CategoryProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CategoryController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = CategoryProduct::all();

        return $this->sendResponse($data, 'Successfully get all category');
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

        $this->validate($request, [
            'photo' => 'required|image|mimes:png,jpg|max:5120',
        ]);

        $data['slug'] = \Str::slug($request->name);

        if($request->hasFile('photo')){
            $images = $request->file('photo');

            $extension = $images->getClientOriginalExtension();

            $file_name = $data['slug'] . "." . $extension;

            $data['photo'] = $images->storeAs('categories', $file_name, 'public');
        }

        CategoryProduct::create($data);

        return $this->sendResponse($data, 'Successfully create category');
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
        $data = CategoryProduct::where('slug', $slug)->get();

        return $this->sendResponse($data, 'Successfully get category');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = $request->all();
        $category = CategoryProduct::findOrFail($id);
        $data['slug'] = \Str::slug($request->name);

        if($request->hasFile('photo')){
            if($category->photo){
                Storage::disk('public')->delete($category->photo);
            }

            $images = $request->file('photo');

            $extension = $images->getClientOriginalExtension();

            $file_name = $data['slug'] . "." . $extension;

            $data['photo'] = $images->storeAs('categories', $file_name, 'public');
        } else {
            $data['photo'] = $category->photo;
        }

        $category->update($data);

        return $this->sendResponse($data, 'Successfully update category');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category = CategoryProduct::findOrFail($id);

        if($category->photo){
            Storage::disk('public')->delete($category->photo);
        }

        $category->delete();

        return $this->sendResponse($category, 'Successfully delete category');
    }
}
