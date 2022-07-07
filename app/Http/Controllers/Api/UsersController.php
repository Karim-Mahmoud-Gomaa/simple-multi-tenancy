<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User as UserModel;
use App\Repository\User\UserFacade as User;
class UsersController extends Controller
{
    public $successStatus = 200;
    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function index(Request $request)
    {
        $paginateNumber=isset($request->paginate)?$request->paginate:0;
        $success['users']=User::index(['*'],[],[],$paginateNumber);
        return response()->json(['success' => $success], $this->successStatus);
    }
    public function update(UserModel $user,Request $request)
    {
        $request->validate([
            'name'=>'nullable|max:100',
            'password'=>'nullable',
            'current_tenant_id'=>'nullable|exists:tenants,id',
            'email'=>'nullable|email|unique:users,email,'.$user->id,
        ]);
        // dd($request->current_tenant_id);
        User::update($user->id,$request);
        return response()->json(['success' => 'done'], $this->successStatus);
    }
   
    public function show(UserModel $user,Request $request)
    {
        $success['user']=User::find($user->id,['*'],['tenants']);
        return response()->json(['success' => $success], $this->successStatus);
    }

    public function store(Request $request)
    {
        $request->validate([
        	'tenant_id'=>'required|exists:tenants,id',
            'name'=>'required|max:100',
            'email'=>'required|email|unique:users,email',
            'password'=>'required|confirmed|min:8',
        ]);
        $success=User::create($request);
        if ($success) {
            return response()->json(['success' => 'User Successfully Created'], $this->successStatus);
        }
        return response()->json(['message' => 'Something Went Wrong ,Please Try Again'], $this->successStatus);
    }

    public function addTenant(Request $request)
    {
        $request->validate(['tenant_id'=>'required|exists:tenants,id']);
        $success=User::addTenant($request->tenant_id);
        return response()->json(['success' => $success], $this->successStatus);
    }

    public function removeTenant(Request $request)
    {
        $request->validate(['tenant_id'=>'required|exists:tenants,id']);
        $success=User::removeTenant($request->tenant_id);
        return response()->json(['success' => $success], $this->successStatus);
    }


}
