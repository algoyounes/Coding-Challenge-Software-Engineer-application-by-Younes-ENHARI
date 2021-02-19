<?php

namespace App\Repositories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;

class CategoryRepository
{
    /**
     * Display a listing of the resource.
     *
     * @return Collection
     */
    public function getAll(): Collection
    {
        return Category::with("parent")->get();
    }

    /**
     * Find category by id.
     *
     * @param  int  $id
     * @return Model
     */
    public function find(int $id): Model
    {
        return Category::findOrfail($id);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param array $category
     * @return Model
     */
    public function create(array $category): Model
    {
        return Category::create($category);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  array $category
     * @param  int  $id
     * @return int
     */
    public function update(array $category, int $id): int
    {
        return Category::where("id", $id)->update($category);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        return Category::where('id', $id)->delete();
    }
}
