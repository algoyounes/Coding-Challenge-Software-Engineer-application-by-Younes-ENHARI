<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\Category;
use App\Services\ICategoryService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{

    private $categoryService;

    /**
     * CategoryController constructor.
     * @param ICategoryService $categoryService
     */
    public function __construct(ICategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->categoryService->getAll();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => ['required', 'max:255'],
            'parent_id' => ['required', 'numeric', 'exists:App\Models\Category,id'],
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors()->toArray(), 422);
        }

        $data = $request->only(['name', 'parent_id']);
        $result = $this->categoryService->create($data);

        return (new Category($result))->response()->setStatusCode(201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $this->categoryService->find($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->only(['name', 'parent_id']);
        $hasUpdated = $this->categoryService->update($data, $id);
        return response()->setStatusCode(200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->categoryService->delete($id);
        return response()->setStatusCode(204);
    }

}
