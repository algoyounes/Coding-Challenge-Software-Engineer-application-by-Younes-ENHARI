<?php

namespace App\Repositories;


interface ICategoryRepository extends IModelRepository
{

    public function getAllCategories();

    public function store(array $product);

    public function destroy($id);

}
