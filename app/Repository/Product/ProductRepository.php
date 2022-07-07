<?php

namespace App\Repository\Product;

use App\Models\Product;
use App\Repository\Product\ProductRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ProductRepository implements ProductRepositoryInterface
{
    // use AuthProductRepository;
    /**
    * @var  Model
    */
    protected $model;
    
    /**
    * BaseRepository constructor.
    *
    * @param  Model $model
    */
    public function __construct(Product $model)
    {
        $this->model = $model;
    }
    public function find(int $id,array $columns=['*'],array $relations=[],array $appends=[]):Product{
        return $this->model->select($columns)->with($relations)->find($id)->append($appends);
    }
    public function index(array $columns=['*'],array $relations=[],array $appends=[],int $paginate=10){
        $user=Auth::user();
        $data= $this->model->where('tenant_id',$user->current_tenant_id)
        ->where('user_id',$user->id)->select($columns)->with($relations);
        if($paginate>0){$data=$data->paginate($paginate);}else{$data=$data->get();}
        if($appends){foreach ($data as $value) {$value->append($appends);}}
        return $data;
    }
    public function create(Request $request):int{
        $model=$this->model->create([
            'name'=>$request->name,
			'price'=>$request->price,
        	'user_id'=>$request->user()->id,
			'tenant_id'=>$request->user()->current_tenant_id,
        ]);
        return $model->id; 
    }
    public function update(int $id,Request $request):bool{
        $model=$this->model->find($id);
        if ($model->user_id==$request->user()->id) {
            return $model->update([
                'name'=>($request->name)?$request->name:$model->name,
                'price'=>($request->price)?$request->price:$model->price,
            ]);
        }
        return false;
    }
    public function delete(int $id):bool{
        $model=$this->model->find($id);
        if ($model->user_id==Auth::user()->id) {
            $model->delete();
            return true;
        }
        return false;
    }
    public function detach(int $user_id,int $tenant_id):bool{
        $this->model->where('user_id','tenant_id')->delete();
        return true;
    }
    
}