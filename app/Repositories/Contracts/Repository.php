<?php


namespace App\Repositories\Contracts;


use Illuminate\Database\Eloquent\Model;

interface Repository
{
    /**
     * @param array $attributes
     * @return Model
     */
    public function create(array $attributes);

    /**
     * @param $id
     * @return Model
     */
    public function find($id);
}
