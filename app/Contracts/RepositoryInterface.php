<?php

namespace App\Contracts;

use Illuminate\Database\Eloquent\Model;

interface RepositoryInterface
{
    public function all();

    public function get(int $id);

    public function save(Model $model);

    public function delete(Model $model);
}