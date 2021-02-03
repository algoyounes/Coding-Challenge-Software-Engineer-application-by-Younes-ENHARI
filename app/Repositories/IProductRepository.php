<?php

namespace App\Repositories;

/**
 * Interface IProductRepository
 * @package App\Repositories
 */
interface IProductRepository extends IModelRepository
{
    public function getAllParents();

    public function show(int $id);
}
