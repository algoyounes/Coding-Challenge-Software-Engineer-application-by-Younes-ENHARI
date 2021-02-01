<?php

namespace App\Services;


interface IProductService
{

    public function getAll();

    public function getAllParents();

    public function find(int $id);

    public function create(array $product, $categoryIds);

    public function update(array $product);

    public function delete(int $id);

}
