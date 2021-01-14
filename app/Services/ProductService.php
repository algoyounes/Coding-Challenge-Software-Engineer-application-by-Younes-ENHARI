<?php

namespace App\Services;

use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Repositories\ProductRepository;
use Illuminate\Support\Facades\Validator;

class ProductService
{

    protected $productRepository;

    public function __construct(ProductRepository $productRepository) {
        $this->productRepository = $productRepository;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getAll($request)
    {
        return $this->productRepository->getAllProducts($request);
    }

    public function getById($request){
        return $this->productRepository->getProductById($request);
    }

    public function storeData($data) {
        $this->productRepository->store($data);
    }

    public function editData($data) {
        $this->productRepository->update($data);
    }

    public function deleteById($id)
    {
        DB::beginTransaction();

        try {
            $this->productRepository->destroy($id);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::info($e->getMessage());

            throw new InvalidArgumentException('Unable to delete category data');
        }

        DB::commit();

        return $product;
    }
}
