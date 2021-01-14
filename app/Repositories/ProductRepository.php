<?php

namespace App\Repositories;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;

class ProductRepository
{

    protected $product;

    public function __construct(Product $product) {
        $this->product = $product;
    }

    /**
     * Display a listing of the Products.
     *
     * @return \Illuminate\Http\Response
     */
    public function getAllProducts(){
        return $this->product->with('categories')->get();
    }

    public function getProductById($id){
        return $this->product->find($id);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $data
     * @return \Illuminate\Http\Response
     */
    public function store($data) {
        $product = new $this->product;

        $product->name = $request->input('name');
        $product->description = $request->input('description');
        $product->price = $request->input('price');

        if ($request->hasFile('photo') && $request->file('photo')->isValid()) {
            $product->image = $this->productImage($request->photo);
        }

        $product->save();

        $category_ids = explode(",", $request->input('category_id'));
        $product->categories()->attach($category_ids);

        return response()->json($product, 201);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $product = $this->getProductById($id);

        $product->name = $request->input('name');
        $product->description = $request->input('description');
        $product->price = $request->input('price');

        if ($request->hasFile('photo') && $request->file('photo')->isValid()) {
            $product->image = $this->productImage($request->photo);
        }

        if($request->filled('category_id')){
            $product->categories()->sync($request->input('category_id'));
        }

        $product->save();

        return response()->json($product, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = $this->getProductById($id);
        $product->delete();
        return response()->json(null, 204);
    }

    /**
     * Store a newly product image.
     *
     */
    public function productImage($image){
        $path = $image->store('products');
        return 'storage/'.$path;
    }

}
