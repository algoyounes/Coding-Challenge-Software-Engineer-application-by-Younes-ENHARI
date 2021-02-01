<?php

namespace App\Services;

use App\Repositories\ICategoryRepository;
use App\Services\ICategoryService;
use Illuminate\Database\Eloquent\Model;

class CategoryService implements ICategoryService
{

    /**
     * @var ICategoryRepository
     */
    protected $categoryRepository;

    public function __construct(ICategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getAll()
    {
        return $this->categoryRepository->getAllCategories();
    }

    /**
     * Display category by id.
     *
     * @param int $id
     * @return json
     */
    public function find($id)
    {
        return $this->categoryRepository->find($id);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param array $category
     * @return Model
     */
    public function create($category)
    {
        return $this->categoryRepository->store($category);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  array  $data
     * @param int $id
     * @return int
     */
    public function update($category, $id)
    {
        return $this->categoryRepository->update($category, $id);
    }

    /**
     * Remove the specified category from storage.
     *
     * @param  int $id
     * @return int
     */
    public function delete($id)
    {
        return $this->categoryRepository->delete($id);
    }
}
