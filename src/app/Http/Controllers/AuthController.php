<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\StoreUserRequest;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Session;
use Auth;
class AuthController extends Controller
{
    use HttpResponses;

    

    public function login(){
        return view('admin.login');
    }

    private function generateAdminCode(){
        $ch=true;
        while($ch){
            $token = rand(100000,999999);
            $user = User::where('admin_code','=',$token)->first();
            $ch = (!empty($user))?true:false;
        }
        return $token;
    }

    public function register(StoreUserRequest $request){

        $request->validated($request->all());

        $user = User::create([
                'name'=>$request->name,
                'email'=>$request->email,
                'password'=> Hash::make($request->password),
                'remember_token' => Str::random(10),
                'email_verified_at'=>now(),
                'admin_code'=>$this->generateAdminCode()
        ]);

             
       
        return $this->success([
            'user'=>$user,
            'token'=>$this->createToken($user)
        ]);
     //   return  response()->json("register");
    }

    private function createToken(User $user){
        $token = $user->createToken('API Token of'.$user->name)->plainTextToken;
        Session::put('token',$token);
        return $token;
    }
    
    public function login_post(LoginUserRequest $request){
 

         $request->validated($request->all());
     //  $validatedData = $request->validated();

        if(!Auth::attempt(['admin_code' => $request->admin_code, 'password' => $request->password])){
            return $this->error('','kullanıcı bulunamadı',401);
        }

        $user = User::where('admin_code',$request->admin_code)->first();
            
        return  $this->success(['user'=>$user,'token'=>$this->createToken($user)]);
    }

    public function logout(Request $request){
         Auth::user()->currentAccessToken()->delete();

        return $this->success('','logged out',200);
    }
}
