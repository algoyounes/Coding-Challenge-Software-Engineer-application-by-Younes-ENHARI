<?php

namespace App\Services;

use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\Model;
use App\Repositories\ProductRepository;
use Illuminate\Database\Eloquent\Collection;

class ProductService
{
    /**
     * @var ProductRepository
     */
    protected $productRepository;

    /**
     * ProductService constructor
     * @param ProductRepository $productRepository
     */
    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Collection
     */
    public function getAll(): Collection
    {
        return $this->productRepository->getAll();
    }

    /**
     * Display category by id.
     *
     * @param  int $id
     * @return Model
     */
    public function find(int $id): Model
    {
        return $this->productRepository->find($id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return array
     */
    public function show(int $id): array
    {
        return $this->productRepository->show($id)->toArray();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  array $product
     * @return Model
     */
    public function create(array $product): Model
    {
        return $this->productRepository->create($product);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  array $product
     * @param  int   $id
     * @return int
     */
    public function update(array $product, int $id): int
    {
        return $this->productRepository->update($product, $id);
    }

    /**
     * Remove the specified category from storage.
     *
     * @param  int  $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        return $this->productRepository->delete($id);
    }

    /**
     * Get the validation rules that apply to the commande line.
     *
     * @param array $data
     * @return bool
     */
    public function validate(array $data): bool
    {
        $validator = Validator::make($data, [
            'name' => ['required', 'max:255'],
            'description' => ['max:255'],
            'price' => ['required', 'numeric', 'between:0,999999.99'],
            'category_id' => ['required', 'numeric', 'exists:App\Models\Category,id'],
        ]);
        if ($validator->fails()) {
            return false;
        }
        return true;
    }
}
