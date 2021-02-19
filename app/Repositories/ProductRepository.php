<?php

namespace App\Repositories;

use App\Models\Product;
use App\Services\ProductAvatarManager;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;

class ProductRepository
{
    /**
     * @var ProductAvatarManager
     */
    private $avatarManager;

    /**
     * ProductRepository constructor
     * @param ProductAvatarManager $avatarManager
     * @return void
     */
    public function __construct(ProductAvatarManager $avatarManager)
    {
        $this->avatarManager = $avatarManager;
    }

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
        return Product::find($id);
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

        if (isset($data["category_id"]) && !empty($data["category_id"])) {
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
        $product = $this->find($id);

        if (!$product) return 0;

        if (isset($data["category_id"]) && !empty($data["category_id"])) {
            $category_ids = explode(",", $data["category_id"]);
            $product->categories()->sync($category_ids);
        }

        return $product->update($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        $product = $this->find($id);

        if (!$product) return false;

        $this->avatarManager->deleteImageProduct($product->image);

        return $product->delete();
    }
}
