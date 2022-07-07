<?php

namespace App\Repository\Tenant;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use App\Models\Tenant;
use Illuminate\Http\Request;

interface TenantRepositoryInterface {
    public function find(int $id,array $columns=['*'],array $relations=[],array $appends=[]):Tenant;
    public function index(array $columns=['*'],array $relations=[],array $appends=[],int $paginate=10);
    public function create(Request $request):int;
    public function update(int $id,Request $request):bool;
    public function delete(int $id):bool;
}