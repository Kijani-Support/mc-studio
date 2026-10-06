<?php

namespace App\Http\Controllers;

use Validator;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\BaseController;
use App\Http\Resources\CustomerResource;

class CustomerController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::whereHas(
            'roles', function($q){
                $q->where('name', 'Customer');
            }
        )->get();
        return new CustomerResource($users);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required',
            'phone_number' => 'required',
        ]);
   
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }
        $user = User::where('email', '=', $request->email)->first();
        if ($user === null) {
        $newuser = new User;
        $newuser->name = $request->name;
        $newuser->email = $request->email;
        $newuser->username = $request->username ? $request->username : $request->email ;
        $newuser->phone_number = $request->phone_number;
        $newuser->save();
        if(!$role = Role::where('name', 'customer')->first()){
            $role = Role::create(['name' => 'customer']);
        }
        $newuser->assignRole($role);
        $success['name'] =  $newuser->name;
   
        return $this->sendResponse($success, 'User register successfully.');
        }
        else{
            return $this->sendError('Validation Error.','Email Already Exists');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }
}
