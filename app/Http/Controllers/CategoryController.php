<?php

namespace App\Http\Controllers;

use App\Exceptions\NullNameException;
use App\Http\Requests\CategoryRequest;
use App\Services\CategoryService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class CategoryController extends Controller
{
    /**
     * @var CategoryService
     */
    private $categoryService;

    /**
     * CategoryController constructor.
     * @param CategoryService $categoryService
     * @return void
     */
    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        return $this->respondWithArray($this->categoryService->getAll()->toArray());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        $data = $request->only(["name", "parent_id"]);

        try {

            $result = $this->categoryService->create($data["name"], $data["parent_id"])->toArray();
            return $this->respondWithItem($result);
        } catch (ModelNotFoundException $e) {

            return $this->errorNotFound("ParentId is not exist !");
        } catch (NullNameException $e) {

            return $this->errorNotFound($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function show(int $id)
    {
        return $this->respondWithItem($this->categoryService->find($id)->toArray());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  CategoryRequest $request
     * @param  int  $id
     * @return JsonResponse
     */
    public function update(CategoryRequest $request, int $id)
    {
        $res = $this->categoryService->update($request->validated(), $id);

        if($res === 0) return $this->errorNotFound("Oops, this category doesn't exist !");

        return $this->respondWithArray([ "message" => "Category updated successfuly" ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function destroy(int $id)
    {
        $res = $this->categoryService->delete($id);

        if (!$res) {
            return $this->errorNotFound("Oops, this category doesn't exist !");
        }

        return $this->respondWithArray([ "message" => "Category deleted successfuly" ]);
    }
}
