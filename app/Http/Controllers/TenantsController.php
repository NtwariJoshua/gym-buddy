<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Tenant;

class TenantsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tenants = Tenant::all();
        return JsonResponse::create($tenants);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
          'name'=>'required'
        ]);
        if($validator->fails()){
          return JsonResponse::create($validator->messages(),400);
        }
        $tenant = Tenant::create($request->all());
        return JsonResponse::create($tenant);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
      $tenant = null;
      try{
        $tenant = Tenant::findOrFail($id);
      }catch(ModelNotFoundException $e){
        return JsonResponse::create(['message'=>'resource not found'],404);
      }
      $tenant->update($request->all());
      return JsonResponse::create($tenant);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      try{
        $tenant = Tenant::findOrFail($id);
      }catch(ModelNotFoundException $e){
        return JsonResponse::create(['message'=>'resource not found'],404);
      }

      $tenant->delete();
      return JsonResponse::create(['message'=>'resource deleted'],201);

    }
}
