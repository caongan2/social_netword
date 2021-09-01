<?php


namespace App\Http\Services;


interface UserService
{
    public function getAll();
    public function findById($id);
    public function update($request, $id);
    public function create($request);
}
