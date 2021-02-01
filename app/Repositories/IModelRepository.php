<?php

namespace App\Repositories;


use Illuminate\Database\Eloquent\Model;

/**
 * Interface IModelRepository
 * @package App\Repositories
 */
interface IModelRepository
{
    /**
     * @param array $attributes
     * @return Model
     */
    public function create(array $attributes): Model;

    /**
     * @param $id
     * @return Model
     */
    public function find($id);

    public function all();

    public function delete($ids);
}

