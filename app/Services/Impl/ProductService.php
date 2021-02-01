<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Http\Reponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\Model;
use App\Services\IProductService;
use App\Repositories\ProductRepository;

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
        return $this->productRepository->getAllProducts();
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
     * @param int $id
     * @return json
     */
    public function find($id){
        return $this->productRepository->find($id);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Model
     */
    public function create($request)
    {
        return $this->productRepository->store($request);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param int $id
     * @return int
     */
    public function update(Request $request, $id)
    {
        return $this->productRepository->update($request);
    }

    /**
     * Remove the specified category from storage.
     *
     * @param  int  $id
     * @return int
     */
    public function delete($id)
    {
        return $this->categoryRepository->delete($id);
    }
}
