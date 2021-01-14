<?php

namespace App\Services;

use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Repositories\CategoryRepository;
use Illuminate\Support\Facades\Validator;

class CategoryService
{

    protected $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository) {
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

    public function getById($id){
        return $this->categoryRepository->getCategoryById($id);
    }

    public function storeData($data) {

        $this->categoryRepository->store($data);
    }

    public function editData($data, $id) {
        $this->categoryRepository->update($data, $id);
    }

    public function deleteById($id)
    {
        DB::beginTransaction();

        try {
            $this->categoryRepository->destroy($id);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::info($e->getMessage());

            throw new InvalidArgumentException('Unable to delete category data');
        }

        DB::commit();

        return $category;
    }
}
