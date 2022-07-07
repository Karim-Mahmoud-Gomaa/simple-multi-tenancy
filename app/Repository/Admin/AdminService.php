<?php

namespace App\Repository\Admin;

use \Illuminate\Support\Facades\Facade;
use App\Repository\Admin\AdminRepositoryInterface;
use Illuminate\Http\Request;
use App\Models\Admin;

class AdminService extends Facade
{
    protected $AdminRepository;
    public function __construct(AdminRepositoryInterface $AdminRepository)
    {
        $this->AdminRepository = $AdminRepository;
    }
    public function find(int $id,array $columns=['*'],array $relations=[],array $appends=[]):Admin{
        return $this->AdminRepository->find($id,$columns,$relations,$appends);
    }
    public function index(array $columns=['*'],array $relations=[],array $appends=[],int $paginate=10){
        return $this->AdminRepository->index($columns,$relations,$appends,$paginate);
    }
    public function create(Request $request):int{
        return $this->AdminRepository->create($request);
    }
    public function update(int $id,Request $request):bool{
        return $this->AdminRepository->update($id,$request);
    }
    public function login(Request $request){
        return $this->AdminRepository->login($request);
    }
    public function delete(int $id):bool{
        return $this->AdminRepository->delete($id);
    }
    
}