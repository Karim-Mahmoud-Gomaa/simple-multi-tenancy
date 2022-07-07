<?php

namespace App\Repository\User;

use App\Models\User;
use App\Repository\User\UserRepositoryInterface;
use App\Repository\User\AuthUserRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use App\Repository\Notification\NotificationFacade as Notification;
use Illuminate\Support\Facades\Auth;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;
use App\Repository\Product\ProductFacade as Product;

class UserRepository implements UserRepositoryInterface
{
   // use AuthUserRepository;
   /**
   * @var Model
   */
   protected $model;
   
   /**
   * BaseRepository constructor.
   *
   * @param Model $model
   */
   public function __construct(User $model)
   {
      $this->model = $model;
   }
   public function find(int $id,array $columns=['*'],array $relations=[],array $appends=[]):User{
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
         'current_tenant_id'=>($request->current_tenant_id)?$request->current_tenant_id:$model->current_tenant_id,
      ]);
      if ($request->password) {
         $model->update(['password'=>bcrypt($request->password)]);
      }
      return true; 
   }
   
   public function login(Request $request){
      
      $credentials = $request->only('email', 'password');
      $token = auth('user_api')->attempt($credentials);

      $user =User::with('tenants')->find(auth('user_api')->id());
      if ($token&&count($user->tenants)) {
         $user->update(['current_tenant_id'=>$user->tenants[0]->id]);
         return [
            'token' => $token,
            'user' =>  $user,
         ];
      }
      return false;
   }  
   
   public function addTenant(int $tenant_id):string{
      $user =User::with('tenants')->find(Auth::id());
      if (in_array($tenant_id,$user->tenants->pluck('id')->toArray())) {
         return 'this tenant already Linked.';
      }
      $user->tenants()->sync($tenant_id,false);
      return 'this tenant Linked successfully.';
   }
   
   public function removeTenant(int $tenant_id):string{
      $user =User::with('tenants')->find(Auth::id());
      $tenant_ids=$user->tenants->pluck('id')->toArray();
      if (in_array($tenant_id,$tenant_ids)&&count($tenant_ids)>1) {
         $user->tenants()->detach($tenant_id);      
         Product::detach($user->id,$tenant_id);
         return 'this tenant Removed successfully.';
      }
      return 'You Can not remove this tenant.';
   }
   
   public function delete(int $id):bool{
      
      $model=$this->model->find($id);
      return ($model->delete())?true:false;
   }
   
   
}