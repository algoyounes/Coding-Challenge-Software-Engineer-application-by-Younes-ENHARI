<?php

namespace App\Services;

/**
 * Interface IProductService
 * @package App\Services
 */
interface IProductService
{
    public function getAll();

    public function getAllParents();

    public function find(int $id);

    public function create(array $product);

    public function update(array $product, int $id);

    public function delete(int $id);
}
