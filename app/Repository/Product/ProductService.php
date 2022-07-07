<?php

namespace App\Repository\Product;

use \Illuminate\Support\Facades\Facade;
use App\Repository\Product\ProductRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;

class ProductService extends Facade
{
    protected $ProductRepository;
    public function __construct(ProductRepositoryInterface $ProductRepository)
    {
        $this->ProductRepository = $ProductRepository;
    }
    
    public function find(int $id,array $columns=['*'],array $relations=[],array $appends=[]){
        return $this->ProductRepository->find($id,$columns,$relations,$appends);
    }
    
    public function index(array $columns=['*'],array $relations=[],array $appends=[],int $paginate=10){        
        return $this->ProductRepository->index($columns,$relations,$appends,$paginate);
    }
    public function create(Request $request):int{
        return $this->ProductRepository->create($request);
    }
    public function update(int $id,Request $request):bool{
        return $this->ProductRepository->update($id,$request);
    }
    public function delete(int $id):bool{
        return $this->ProductRepository->delete($id);
    }
    
    public function detach(int $user_id,int $tenant_id):bool{
        return $this->ProductRepository->detach($user_id,$tenant_id);
    }
    
    
    
}