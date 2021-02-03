<?php

namespace App\Repositories;

/**
 * Interface IModelRepository
 * @package App\Repositories
 */
interface IModelRepository
{
    public function create(array $attributes);

    public function update(array $attributes, int $id);

    public function find(int $id);

    public function getAll();

    public function delete(int $id);
}
