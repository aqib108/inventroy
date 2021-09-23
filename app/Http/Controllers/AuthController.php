<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
class AuthController extends Controller
{
    //
     /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('JWT', ['except' => ['login','register']]);
    }
//, ['except' => ['login','register']]
    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $validation = $request->validate([
         'email'=>'required',
         'password'=>'required'

        ]);
        $credentials = request(['email', 'password']);

        if (! $token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Email or Password is invalid'], 401);
        }

        return $this->respondWithToken($token);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(auth()->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
            'user_id'=>auth()->user()->id,
            'name'=>auth()->user()->name,
            'email'=>auth()->user()->email,

        ]);
    }
    function register(Request $request)
    {
        
        $validation = $request->validate([
            'email'=>'required|unique:users',
            'password'=>'required|confirmed',
            'name'=>'required'
            
           ]);
           extract($request->all());
           $us = new User;
           $data = array();
           $data['name'] = $name;
           $data['email'] = $email;
           $data['password'] = Hash::make($password);
           if($us::insert($data))
           {
  return $this->login($request);
           }
           else
           {
return reponse()->json(['status'=>204,'message'=>'error in create Account']);
           }

    }
    
}
