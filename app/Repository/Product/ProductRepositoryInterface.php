<?php

namespace App\Repository\Product;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use App\Models\Product;
use Illuminate\Http\Request;

interface ProductRepositoryInterface {
    public function find(int $id,array $columns=['*'],array $relations=[],array $appends=[]):Product;
    public function index(array $columns=['*'],array $relations=[],array $appends=[],int $paginate=10);
    public function create(Request $request):int;
    public function update(int $id,Request $request):bool;
    public function delete(int $id):bool;
    public function detach(int $user_id,int $tenant_id):bool;
}