<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\Product;
use App\Services\IProductService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{

    protected $productService;

    public function __construct(IProductService $productService)
    {
        $this->productService = $productService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->productService->getAll();
    }

    /**
     * Send list of category of parent to add product page
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return $this->productService->getAllParents();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => ['required', 'max:255'],
            'description' => ['max:255'],
            'price' => ['required', 'numeric', 'between:0,999999.99'],
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors()->toArray(), 422);
        }

        $data = $request->only(['name', 'description', 'price', 'category_id', 'image']);
        
        if($data["image"] == NULL){
            unset($data["image"]);
        }else{
            $data["image"] = $this->productImage(trim($data['image']));
        }

        $result = $this->productService->create($data);

        return (new Product($result))->response()->setStatusCode(201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        return $this->productService->show($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, int $id)
    {

        $data = $request->only(['name', 'description', 'price', 'image']);
        $data["image"] = $this->productImage($data["image"]);

        $a = $this->productService->update($data, $id);
        return response()->setStatusCode(200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        $this->productService->delete($id);
    }

    /**
     * Store a newly product image.
     *
     * @param  string $image
     * @return string
     */
    public function productImage($image)
    {
        $path = $image->store('products');
        return 'storage/'.$path;
    }

}

