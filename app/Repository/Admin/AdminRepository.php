<?php

namespace App\Repository\Admin;

use App\Models\Admin;
use App\Repository\Admin\AdminRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Repository\Product\ProductFacade as Product;

class AdminRepository implements AdminRepositoryInterface
{
   // use AuthAdminRepository;
   /**
   * @var Model
   */
   protected $model;
   
   /**
   * BaseRepository constructor.
   *
   * @param Model $model
   */
   public function __construct(Admin $model)
   {
      $this->model = $model;
   }
   public function find(int $id,array $columns=['*'],array $relations=[],array $appends=[]):Admin{
      return $this->model->select($columns)->with($relations)->find($id)->append($appends);
   }
   
   public function index(array $columns=['*'],array $relations=[],array $appends=[],int $paginate=10){
      $data= $this->model->select($columns)->with($relations);
      if($paginate>0){$data=$data->paginate($paginate);}else{$data=$data->get();}
      if($appends){foreach ($data as $value) {$value->append($appends);}}
      return $data;
   }
   public function create(Request $request):int{
      
      $model=$this->model->create(['name'=>$request->name,'email'=>$request->email,
      'password'=>bcrypt(($request->password)?$request->password:$request->email)]);
      
      return $model->id; 
   }
   public function update(int $id,Request $request):bool{
      $model=$this->model->find($id);
      $model->update([
         'name'=>($request->name)?$request->name:$model->name,
         'email'=>($request->email)?$request->email:$model->email,
      ]);
      if ($request->password) {
         $model->update(['password'=>bcrypt($request->password)]);
      }
      return true; 
   }
   
   public function login(Request $request){
      
      $credentials = $request->only('email', 'password');
      $token = auth('admin_api')->attempt($credentials);

      $admin =Admin::find(auth('admin_api')->id());
      if ($token) {
         return [
            'token' => $token,
            'admin' =>  $admin,
         ];
      }
      return false;
   }  

   public function delete(int $id):bool{
      
      $model=$this->model->find($id);
      return ($model->delete())?true:false;
   }
   
   
}