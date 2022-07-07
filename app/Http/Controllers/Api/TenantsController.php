<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repository\Tenant\TenantFacade as Tenant;
use App\Models\Tenant as TenantModel;

class TenantsController extends Controller
{
    public $successStatus = 200;
        public function index(Request $request)
    {
        if(isset($request->paginate)){
            $success['tenants']=Tenant::index(['id','name'],[],[],0);
        }else{
            $success['tenants']=Tenant::index(['*'],[]);
        }
        return response()->json(['success' => $success], $this->successStatus);
    }
    
    public function store(Request $request)
    {
        $request->validate([
        	'name'=>'required|max:255|unique:tenants,name',
			'phone'=>'required|max:255',
			'address'=>'required|max:255',
        ]);
        $success=Tenant::create($request);
        return response()->json(['success' => $success], $this->successStatus);
    }
    
    
    public function show(TenantModel $tenant)
    {
        $success['tenant']=Tenant::find($tenant->id,['*'],[]);
        return response()->json(['success' => $success], $this->successStatus);
    }
    
    /**
    * Update the specified resource in storage.
    *
    * @param    \Illuminate\Http\Request  $request
    * @param    \App\OrderDetail  $tenant
    * @return  \Illuminate\Http\Response
    */
    public function update(Request $request,TenantModel $tenant)
    {
        $request->validate([
        	'name'=>'nullable|max:255|unique:tenants,name,'.$tenant->id,
			'phone'=>'nullable|max:255',
			'address'=>'nullable|max:255',
        ]);
        $success=Tenant::update($tenant->id,$request);
        return response()->json(['success' => $success], $this->successStatus);
    }
    
    /**
    * Remove the specified resource from storage.
    *
    * @param    \App\OrderDetail  $tenant
    * @return  \Illuminate\Http\Response
    */
    public function destroy(TenantModel $tenant)
    {
        $success=Tenant::delete($tenant->id);
        return response()->json(['success' => $success], $this->successStatus);
    }
    
}
