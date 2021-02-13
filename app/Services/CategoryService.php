<?php

namespace App\Services;

use App\Repositories\CategoryRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;

class CategoryService
{

    /**
     * @var CategoryRepository
     */
    protected $categoryRepository;

    /**
     * CategoryService constructor
     * @param CategoryRepository $categoryRepository
     */
    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * Display a listing of the category.
     *
     * @return Collection
     */
    public function getAll(): Collection
    {
        return $this->categoryRepository->getAll();
    }

    /**
     * Display category by id.
     *
     * @param int $id
     * @return Model
     */
    public function find(int $id): ?Model
    {
        return $this->categoryRepository->find($id);
    }

    /**
     * Store a newly created category in storage.
     *
     * @param array $category
     * @return Model
     */
    public function create(array $category): Model
    {
        return $this->categoryRepository->create($category);
    }

    /**
     * Update the specified category in storage.
     *
     * @param  array $data
     * @param  int   $id
     * @return int
     */
    public function update(array $category, int $id): int
    {
        return $this->categoryRepository->update($category, $id);
    }

    /**
     * Remove the specified category from storage.
     *
     * @param  int $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        return $this->categoryRepository->delete($id);
    }
}
