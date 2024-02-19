<?php

namespace App\Http\Controllers\User\Repositories\Eloquent;

use App\Http\Controllers\User\Repositories\UserRepositoryInterface;
use App\Models\User;
use App\Repositories\Eloquent\BaseRepository;
use Illuminate\Support\Collection;

class UserRepository extends BaseRepository implements UserRepositoryInterface
{
    public function __construct(User $model)
    {
        parent::__construct($model);
    }
    

    public function all(): Collection
    {
        return $this->model->all();
    }
}