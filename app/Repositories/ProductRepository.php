<?php

namespace App\Repositories;

use Exception;
use TypeError;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ProductRepository
{

    /**
     * Display a listing of the Products.
     *
     * @return Collection
     */
    public function getAll(): Collection
    {
        return Product::with('categories')->get();
    }

    /**
     * Display the specifies resource
     *
     * @param  int  $id
     * @return Model
     */
    public function show(int $id): Model
    {
        return Product::with('categories')->find($id);
    }

    /**
     * Find category by id.
     *
     * @param  int  $id
     * @return Model
     */
    public function find(int $id): Model
    {
        return Product::findOrfail($id);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  array  $data
     * @return Model
     */
    public function create(array $data): Model
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
    public function update(array $data, int $id): int
    {
        try{
            $product = $this->find($id);
            if(isset($data["category_id"]) && !empty($data["category_id"])){
                $category_ids = explode(",", $data["category_id"]);
                $product->categories()->sync($category_ids);
            }
            $product->update($data);
            return $product;
        }catch(ModelNotFoundException | TypeError $e){
            return 0;
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        try{
            $product = $this->find($id);
            if($product){
                $this->deleteImageProduct($product->image);
                return $product->delete();
            }
        }catch(ModelNotFoundException | TypeError $e){
            return false;
        }
    }

    /**
     * Remove the specified product image from storage.
     *
     * @param string $image
     * @return void
     */
    public function deleteImageProduct(string $image): void
    {
        list($part1, $part2) = explode('/storage/', $image);
        Storage::delete("/public/".$part2);
    }
}
