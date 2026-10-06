<?php
   
namespace App\Http\Controllers;
   
use Validator;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\BaseController as BaseController;
   
class RegisterController extends BaseController
{
    /**
     * Register api
     *
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'username'=> 'required',
            'phone_number'=>'required'
            
        ]);
   
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }
        $input = $request->all();
        $user = User::where('email', '=', $request->email)->first();
        if ($user === null) {
        $user = User::create($input);
        $success['token'] =  $user->createToken('KijaniApp')->plainTextToken;
        $success['name'] =  $user->name;
   
        return $this->sendResponse($success, 'User register successfully.');
        }
        else{
            return $this->sendError('Validation Error.','Email Already Exists');
        }
    }
   public function login(Request $request){
      
    $validator = Validator::make($request->all(), [
        'email' => 'required|email',
        'password'=> 'required',
    ]);
    if($validator->fails()){
        return $this->sendError('Validation Error.', $validator->errors());       
    }
    $user = User::where('email', '=', $request->email)->first();

    if($user){
            if(Auth::attempt(['email' => request('email'), 'password' => request('password')])){ 
                $user = Auth::user(); 
                $success['token'] =  $user->createToken('KijaniApp')->plainTextToken;
                $success['name'] =  $user->name;
                 return $this->sendResponse($success, 'Logged In Successfully');
            } 
            else{ 
                return $this->sendError('Validation Error.','Incorrect Email/Password');
            } 
    }
    else{
        return $this->sendError('Validation Error.','User not found');
    }
   }
}