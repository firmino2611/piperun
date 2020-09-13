<?php

namespace App\Repositories\Contracts;

use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

interface RepositoryInterface
{
    /**
     * @param array $data
     * @return mixed
     */
    public function create (Array $data);

    public function updateById (int $task, array $data);

    public function deleteById (int $id);

}
