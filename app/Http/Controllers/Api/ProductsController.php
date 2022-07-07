<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repository\Product\ProductFacade as Product;
use App\Models\Product as ProductModel;

class ProductsController extends Controller
{
    public $successStatus = 200;
    public function index(Request $request)
    {
        $success['products']=Product::index(['*'],[]);
        return response()->json(['success' => $success], $this->successStatus);
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'name'=>'required|max:255',
            'price'=>'required|regex:/^-?[0-9]+(?:\.[0-9]{1,2})?$/',
        ]);
        $success=Product::create($request);
        return response()->json(['success' => $success], $this->successStatus);
    }
    
    
    public function show(ProductModel $product)
    {
        $success['product']=Product::find($product->id,['*'],[]);
        return response()->json(['success' => $success], $this->successStatus);
    }
    
    /**
    * Update the specified resource in storage.
    *
    * @param    \Illuminate\Http\Request  $request
    * @param    \App\OrderDetail  $product
    * @return  \Illuminate\Http\Response
    */
    public function update(Request $request,ProductModel $product)
    {
        $request->validate([
            'name'=>'nullable|max:255',
            'price'=>'nullable|regex:/^-?[0-9]+(?:\.[0-9]{1,2})?$/',
        ]);
        $success=Product::update($product->id,$request);
        if ($success) {
            return response()->json(['success' => 'done'], $this->successStatus);
        }
        abort(404);
    }
    
    /**
    * Remove the specified resource from storage.
    *
    * @param    \App\OrderDetail  $product
    * @return  \Illuminate\Http\Response
    */
    public function destroy(ProductModel $product)
    {
        $success=Product::delete($product->id);
        if ($success) {
            return response()->json(['success' => 'done'], $this->successStatus);
        }
        abort(404);
    }
    
}
