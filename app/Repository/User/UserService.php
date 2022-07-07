<?php

namespace App\Repository\User;

use \Illuminate\Support\Facades\Facade;
use App\Repository\User\UserRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use App\Models\User;

class UserService extends Facade
{
    protected $UserRepository;
    public function __construct(UserRepositoryInterface $UserRepository)
    {
        $this->UserRepository = $UserRepository;
    }
    public function find(int $id,array $columns=['*'],array $relations=[],array $appends=[]):User{
        return $this->UserRepository->find($id,$columns,$relations,$appends);
    }
    public function index(array $columns=['*'],array $relations=[],array $appends=[],int $paginate=10){
        return $this->UserRepository->index($columns,$relations,$appends,$paginate);
    }
    public function create(Request $request):int{
        return $this->UserRepository->create($request);
    }
    public function update(int $id,Request $request):bool{
        return $this->UserRepository->update($id,$request);
    }
    public function login(Request $request){
        return $this->UserRepository->login($request);
    }
    public function addTenant(int $tenant_id):string{
        return $this->UserRepository->addTenant($tenant_id);
    }
    public function removeTenant(int $tenant_id):string{
        return $this->UserRepository->removeTenant($tenant_id);
    }
    public function delete(int $id):bool{
        return $this->UserRepository->delete($id);
    }
    
}