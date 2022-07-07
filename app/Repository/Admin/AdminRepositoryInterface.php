<?php

namespace App\Repository\Admin;
use Illuminate\Database\Eloquent\Collection;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface AdminRepositoryInterface {
    public function find(int $id,array $columns=['*'],array $relations=[],array $appends=[]):Admin;
    public function index(array $columns=['*'],array $relations=[],array $appends=[],int $paginate=10);
    public function create(Request $request):int;
    public function update(int $id,Request $request):bool;
    public function delete(int $id):bool;
   
    public function login(Request $request);

}