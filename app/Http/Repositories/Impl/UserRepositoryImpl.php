<?php


namespace App\Http\Repositories\Impl;


use App\Http\Repositories\Eloquent\EloquentRepository;
use App\Http\Repositories\UserRepository;
use App\Models\User;

class UserRepositoryImpl extends EloquentRepository implements UserRepository
{

    public function getModel()
    {
        $model = User::class;
        return $model;
    }
}
