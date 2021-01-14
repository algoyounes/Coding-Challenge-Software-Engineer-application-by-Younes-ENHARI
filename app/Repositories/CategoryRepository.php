<?php

namespace App\Repositories;

use App\Models\Category;

class CategoryRepository
{

    protected $category;

    public function __construct(Category $category) {
        $this->category = $category;
    }

        /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getAllCategories(){
        return $this->category->with('parent')->get();
    }

    public function getCategoryById($id){
        return $this->category->find($id);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($data) {
        $category = new $this->category;
        $category->name = $request->input('name');

        if($request->filled('parent_id')){
            $category_parent = $this->getCategoryById($request->input('parent_id'));
            $category->parent()->associate($category_parent);
        }

        $category->save();
        return response()->json($category, 201);
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
        $category = $this->getCategoryById($id);
        $category->name = $request->input('name');

        if($request->filled('parent_id') && $request->input('parent_id') != $category->parent_id){
            $category_parent = $this->getCategoryById($request->input('parent_id'));
            $category->parent()->associate($category_parent);
        }

        $category->save();
        return response()->json($category, 200);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = $this->getCategoryById($id);
        $category->delete();

        return response()->json(null, 204);
    }
}
