<?php

namespace App\Services\Implement;

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
        return $this->categoryRepository->getAll();
    }

    /**
     * Display category by id.
     *
     * @param int $id
     * @return Model
     */
    public function find(int $id)
    {
        return $this->categoryRepository->find($id);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param array $category
     * @return Model
     */
    public function create(array $category)
    {
        return $this->categoryRepository->create($category);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  array $data
     * @param  int   $id
     * @return int
     */
    public function update(array $category, int $id)
    {
        return $this->categoryRepository->update($category, $id);
    }

    /**
     * Remove the specified category from storage.
     *
     * @param  int $id
     * @return int
     */
    public function delete(int $id)
    {
        return $this->categoryRepository->delete($id);
    }
}
