<?php

namespace App\Services;

/**
 * Interface ICategoryService
 * @package App\Services
 */
interface ICategoryService
{
    public function getAll();

    public function find(int $id);

    public function create(array $category);

    public function update(array $category, int $id);

    public function delete(int $id);
}
