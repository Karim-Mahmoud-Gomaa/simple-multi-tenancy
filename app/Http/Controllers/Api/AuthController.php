<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repository\User\UserFacade as User;
use App\Repository\Admin\AdminFacade as Admin;
use Illuminate\Support\Facades\Http;

class AuthController extends Controller
{
    public $successStatus = 200;
    
    public function login(Request $request)
    { 
        $request->validate(['email' => 'required','password' => 'required|min:6']);
        $success = User::login($request);
        if ($success) {
            return response()->json(['success' => $success], $this->successStatus);
        }
        return response()->json(["error" => "Your email/Password is wrong.."], 401);
    }
    public function user(Request $request)
    {
        $success['user']=User::find($request->user()->id,['*'],['tenants']);
        return response()->json(['success' => $success], $this->successStatus);
    }

    public function adminLogin(Request $request)
    { 
        $request->validate(['email' => 'required','password' => 'required|min:6']);
        $success = Admin::login($request);
        if ($success) {
            return response()->json(['success' => $success], $this->successStatus);
        }
        return response()->json(["error" => "Your email/Password is wrong.."], 401);
    }
    public function admin(Request $request)
    {
        $success['admin']=Admin::find($request->user()->id,['*'],[]);
        return response()->json(['success' => $success], $this->successStatus);
    }
   
}
    