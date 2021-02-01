<?php

namespace App\Repositories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Model;
use App\Repositories\ICategoryRepository;

class CategoryRepository implements ICategoryRepository
{

    /**
     * @var Category
     */
    protected $model;

    /**
     * CategoryRepository constructor.
     * @param Category $model
     */
    public function __construct(Category $model)
    {
        $this->model = $model;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getAllCategories()
    {
        return $this->model->with("parent")->get();
    }

    /**
     * Find category by id.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function find($id)
    {
        return $this->model->find($id);
    }

    /**
     * @param array $category
     * @return mixed
     */
    public function store($category)
    {
        return $this->model->create($category);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  array $category
     * @param  int  $id
     * @return mixed
     */
    public function update($category, $id)
    {
        return $this->model->where("id", $id)->update($category);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return int
     */
    public function delete($id)
    {
        $category = $this->find($id);
        return $category->delete($id);
    }
}
