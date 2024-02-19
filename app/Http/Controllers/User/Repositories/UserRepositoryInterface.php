<?php

namespace App\Http\Controllers\User\Repositories;

use Illuminate\Support\Collection;

interface UserRepositoryInterface
{
    public function all(): Collection;
}