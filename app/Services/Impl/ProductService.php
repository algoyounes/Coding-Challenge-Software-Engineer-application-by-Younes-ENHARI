<?php

namespace App\Services\Impl;

use Illuminate\Http\Request;
use Illuminate\Http\Reponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\Model;
use App\Services\IProductService;
use App\Repositories\Impl\ProductRepository;

class ProductService implements IProductService
{

    protected $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function getAll()
    {
        return $this->productRepository->getAll();
    }

    /**
     * Display a listing of categories of parent.
     *
     * @return Response
     */
    public function getAllParents()
    {
        return $this->productRepository->getAllParents();
    }

    /**
     * Display category by id.
     *
     * @param  int $id
     * @return Model
     */
    public function find(int $id)
    {
        return $this->productRepository->find($id);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  array $product
     * @return Model
     */
    public function create(array $product)
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
    public function update(array $product, int $id)
    {
        return $this->productRepository->update($request);
    }

    /**
     * Remove the specified category from storage.
     *
     * @param  int  $id
     * @return int
     */
    public function delete(int $id)
    {
        return $this->categoryRepository->delete($id);
    }
}
