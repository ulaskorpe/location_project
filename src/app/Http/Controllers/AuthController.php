<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\StoreUserRequest;
use App\Http\Resources\UserResource;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
 
class AuthController extends Controller
{
    use HttpResponses;
 
 

    public function register(StoreUserRequest $request){

        $request->validated($request->all());

        $user = User::create([
                'name'=>$request->name,
                'email'=>$request->email,
                'password'=> Hash::make($request->password),
                'remember_token' => Str::random(10),
                'email_verified_at'=>now(),
               
        ]);

             
       
        return $this->success([
            'user'=>$user,
            'token'=>$this->createToken($user)
        ],'user created',201);
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

        if(!Auth::attempt(['email' => $request->email, 'password' => $request->password])){
            return $this->error('','kullanıcı bulunamadı',401);
        }

        $user = User::where('email',$request->email)->first();
            
        return  $this->success(['user'=>new UserResource($user),'token'=>$this->createToken($user)]);
 
    }

    public function logout(Request $request){
        // Auth::user()->currentAccessToken()->delete();
        
          DB::table('personal_access_tokens')->where('tokenable_id','=',Auth::user()->first()->id)->delete();

         return $this->success('','logged out',200);
    }

    public function me(Request $request){
      
   
        Session::put('token',null);
        return  $this->success(['user'=>new UserResource(Auth::user()->first()),'token'=>Auth::user()->tokens()->latest()->first()]);
    }

    protected function throttleKey(Request $request)
    {
        return mb_strtolower($request->input('email')) . '|' . $request->ip();
    }
}
