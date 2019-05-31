<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\User;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\DB;


class AuthController extends Controller
{

    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    /**
     * Do Register User To Db
     */
    public function register(Request $request){
        $validatedData = $request->validate([
            'name' => 'required|max:255|min:3',
            'email' => 'required|email|unique:users',
            'username' => 'required|unique:users',
            'password' => 'required|min:8',
        ]);

        $validatedData['password'] =  Hash::make($validatedData['password'], [
            'rounds' => 12
        ]);

        $user = User::create($validatedData);

        $token = JWTAuth::fromUser($user);

        return response()->json(["message" => "Berhasil Daftar", "user" => $user, "token" => $token], 201);
    }

    /**
     * Do Login User
     * 
     * @param Request request
     * 
     * @return JsonResponse
     */
    public function login(Request $request){

        $credentials = request(['email', 'password']);

        if ($token = JWTAuth::attempt($credentials)) {
            $user = DB::table('users')->select(['email', 'id', 'username', 'name', 'avatar'])->where('email', $request->email)->first();
            return $this->respondWithToken($token, $user);
        }

        return response()->json(['message' => 'Unauthorized'], 401);
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
    protected function respondWithToken($token, $user = null)
    {
        return response()->json([
            'message' => 'Berhasil Login',
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60,
            'user' => $user,
        ]);
    }
}
