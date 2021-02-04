<?php

namespace App\Repositories\Implement;

use App\Models\Category;
use Illuminate\Database\Eloquent\Model;
use App\Repositories\ICategoryRepository;

class CategoryRepository implements ICategoryRepository
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getAll()
    {
        return Category::with("parent")->get();
    }

    /**
     * Find category by id.
     *
     * @param  int  $id
     * @return Model
     */
    public function find(int $id)
    {
        return Category::find($id);
    }

    /**
     * @param array $category
     * @return mixed
     */
    public function create(array $category)
    {
        return Category::create($category);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  array $category
     * @param  int  $id
     * @return mixed
     */
    public function update(array $category, int $id)
    {
        return Category::where("id", $id)->update($category);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return int
     */
    public function delete(int $id)
    {
        $category = $this->find($id);
        return $category->delete($id);
    }
}
