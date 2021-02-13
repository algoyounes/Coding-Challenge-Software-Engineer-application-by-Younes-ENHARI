<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\Product;
use App\Http\Requests\ProductRequest;
use App\Services\ProductService;
use Illuminate\Http\JsonResponse;

class ProductController extends Controller
{
    /**
     * @var ProductService
     */
    protected $productService;

    /**
     * ProductController constructor.
     * @param ProductService $productService
     */
    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        return $this->respondWithArray($this->productService->getAll()->toArray());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  ProductRequest $request
     * @return JsonResponse
     */
    public function store(ProductRequest $request)
    {
        $data = $request->only(['name', 'description', 'price', 'category_id']);
        $data["image"] = $this->productService->uploadImage($request->file("image"));
        $result = $this->productService->create($data)->toArray();
        return $this->respondWithItem($result);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function show(int $id)
    {
        return $this->respondWithArray($this->productService->show($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  ProductRequest  $request
     * @param  int  $id
     * @return JsonResponse
     */
    public function update(ProductRequest $request, int $id)
    {
        $data = $request->only(['name', 'description', 'price']);
        $data["image"] = $this->productService->uploadImage($request->file("image"));
        $res = $this->productService->update($data, $id);
        if($res === 0) return $this->errorNotFound("Oops, this product doesn't exist !");
        return $this->respondWithArray([ "message" => "Product updated successfuly" ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function destroy(int $id)
    {
        $res = $this->productService->delete($id);
        if(!$res){
            return $this->errorNotFound("Oops, this product doesn't exist !");
        }
        return $this->respondWithArray([ "message" => "Product deleted successfuly" ]);
    }
}
