<?php

namespace App\Repository\Tenant;

use \Illuminate\Support\Facades\Facade;
use App\Repository\Tenant\TenantRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;

class TenantService extends Facade
{
    protected $TenantRepository;
    public function __construct(TenantRepositoryInterface $TenantRepository)
    {
        $this->TenantRepository = $TenantRepository;
    }
    
    public function find(int $id,array $columns=['*'],array $relations=[],array $appends=[]){
        return $this->TenantRepository->find($id,$columns,$relations,$appends);
    }
    
    public function index(array $columns=['*'],array $relations=[],array $appends=[],int $paginate=10){        
        return $this->TenantRepository->index($columns,$relations,$appends,$paginate);
    }
    public function create(Request $request):int{
        return $this->TenantRepository->create($request);
    }
    public function update(int $id,Request $request):bool{
        return $this->TenantRepository->update($id,$request);
    }
    public function delete(int $id):bool{
        return $this->TenantRepository->delete($id);
    }
    
    
    
}