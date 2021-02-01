<?php

namespace App\Repositories;

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
     * @var Product
     */
    protected $model;

    /**
     * ProductRepository constructor.
     * @param Product $model
     */
    public function __construct(Product $model)
    {
        $this->model = $model;
    }


    /**
     * Display a listing of the Products.
     *
     * @return Response
     */
    public function getAllProducts()
    {
        return $this->model->with('categories')->get();
    }

    /**
     * Send list of category of parent to add product page
     *
     * @return Response
     */
    public function getAllParents()
    {
        return $this->model->doesntHave('parent')->get();
    }

    /**
     * Display the specifies resource
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        return $this->model->with('categories')->find($id);
    }

    /**
     * Find category by id.
     *
     * @param  int  $id
     * @return Model
     */
    public function find($id)
    {
        return $this->model->find($id);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Model
     */
    public function store(Request $request)
    {

        $product = $request->only(['name', 'description', 'price', 'category_id', 'image']);
        $product["image"] = $this->productImage(trim($product['image']));

        $data = $this->model->create($product);

        if(is_array($product["category_id"]) && !empty($product["category_id"])){
            $category_ids = explode(",", $product["category_id"]);
            $data->categories()->attach($category_ids);
        }

        return $data;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return int
     */
    public function update(Request $request, $id)
    {

        $product = $request->only(['name', 'description', 'price', 'photo']);
        $product["photo"] = $this->productImage($product["photo"]);

        $data = $this->model->where("id", $id);
        $data->categories()->sync($request->input('category_id'));
        $data->update($product);

        return $data;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return int
     */
    public function delete($id)
    {
        $product = $this->find($id);
        return $product->delete($id);
    }

    /**
     * Store a newly product image.
     *
     */
    public function productImage($image)
    {
        $path = $image->store('products');
        return 'storage/'.$path;
    }

}
