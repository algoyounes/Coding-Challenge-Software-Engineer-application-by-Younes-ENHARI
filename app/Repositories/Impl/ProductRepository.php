<?php

namespace App\Repositories\Impl;

use Illuminate\Http\Request;
use Illuminate\Http\Reponse;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;
use App\Repositories\IProductRepository;

class ProductRepository implements IProductRepository
{

    /**
     * Display a listing of the Products.
     *
     * @return Response
     */
    public function getAll()
    {
        return Product::with('categories')->get();
    }

    /**
     * Send list of category of parent to add product page
     *
     * @return Response
     */
    public function getAllParents()
    {
        return Product::doesntHave('parent')->get();
    }

    /**
     * Display the specifies resource
     *
     * @param  int  $id
     * @return Response
     */
    public function show(int $id)
    {
        return Product::with('categories')->find($id);
    }

    /**
     * Find category by id.
     *
     * @param  int  $id
     * @return Model
     */
    public function find(int $id)
    {
        return Product::find($id);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  array  $data
     * @return Model
     */
    public function create(array $data)
    {
        $product = Product::create($data);

        if(isset($data["category_id"]) && !empty($data["category_id"])){
            $category_ids = explode(",", $data["category_id"]);
            $product->categories()->attach($category_ids);
        }

        return $product;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  array $data
     * @param  int   $id
     * @return int
     */
    public function update(array $data, int $id)
    {
        $product = Product::where("id", $id);
        if(isset($data["image"]) && !empty($data["image"])){
            $product->categories()->sync($data["image"]);
        }
        $product->update($data);

        return $product;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return int
     */
    public function delete(int $id)
    {
        $product = $this->find($id);
        return $product->delete($id);
    }

}
