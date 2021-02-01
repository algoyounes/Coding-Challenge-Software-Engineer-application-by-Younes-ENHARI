<?php

namespace App\Repositories;


interface IProductRepository extends IModelRepository
{

    public function getAllCategories();

    public function store(array $product, $categoryIds);

    public function show($id);

}
