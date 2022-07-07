<?php

namespace App\Repository\Tenant;

use App\Models\Tenant;
use App\Repository\Tenant\TenantRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TenantRepository implements TenantRepositoryInterface
{
    // use AuthTenantRepository;
    /**
    * @var  Model
    */
    protected $model;
    
    /**
    * BaseRepository constructor.
    *
    * @param  Model $model
    */
    public function __construct(Tenant $model)
    {
        $this->model = $model;
    }
    public function find(int $id,array $columns=['*'],array $relations=[],array $appends=[]):Tenant{
        return $this->model->select($columns)->with($relations)->find($id)->append($appends);
    }
    public function index(array $columns=['*'],array $relations=[],array $appends=[],int $paginate=10){
        
        $data= $this->model->whereIn('id',Auth::user()->tenants->pluck('id')->toArray())
        ->select($columns)->with($relations);
        if($paginate>0){$data=$data->paginate($paginate);}else{$data=$data->get();}
        if($appends){foreach ($data as $value) {$value->append($appends);}}
        return $data;
    }
    public function create(Request $request):int{
        $model=$this->model->create([
        	'name'=>$request->name,
			'phone'=>$request->phone,
			'address'=>$request->address,
        ]);
        return $model->id; 
    }
    public function update(int $id,Request $request):bool{
        $model=$this->model->find($id);
        return ($model->update([
        	'name'=>($request->name)?$request->name:$model->name,
        	'phone'=>($request->phone)?$request->phone:$model->phone,
        	'address'=>($request->address)?$request->address:$model->address,
        ]))?1:0;
    }
    public function delete(int $id):bool{
        $model=$this->model->find($id);
        return ($model->delete())?1:0;
    }
    
}