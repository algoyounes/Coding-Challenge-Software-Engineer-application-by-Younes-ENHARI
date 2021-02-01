<?php

namespace App\Services;


interface ICategoryService
{

    public function getAll();

    public function find(int $id);

    public function create(array $category);

    public function update(array $category);

    public function delete(int $id);

}
