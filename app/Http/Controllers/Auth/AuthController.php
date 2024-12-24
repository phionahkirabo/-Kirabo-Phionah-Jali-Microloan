<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthController extends Controller
{


        /**
     * @OA\Info(title="JALI-MICROLOAN", version="1.0.0")
     * @OA\Post(
     *      path="/api/register",
     *      security={{"Bearer": {}}},
     *      operationId="register ",
     *      tags={"Authentication"},
     *      summary="Register a new user",
     *      description="Register a new user and return the inserted data",
     *      @OA\Parameter(
     *          name="first_name",
     *          description="enter first name",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="last_name",
     *          description="Last_name of user",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="telephone",
     *          description="user's telephone",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="password",
     *          description="enter password",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *     @OA\Parameter(
     *          name="user_type",
     *          description="user type admin,end_user",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="User successfully registered",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="first_name", type="string", example="phionah"),
     *              @OA\Property(property="last_name", type="string", example="kirabo"),
     *              @OA\Property(property="telephone", type="string", example="0785643266"),
     *              @OA\Property(property="password", type="string", example="123@we"),
     *              @OA\Property(property="user_type", type="string", example="like admin,end_user"),
     *             
     *          )
     *      ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad user input"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated"
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Resource not found"
     *      )
     * )
     */


    function register(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:50',
            'last_name' => 'required|string|max:50',
            'telephone' => 'required|string|max:10|unique:users',
            'password' => 'required|string|min:6',
        ]);

        $user = User::create([
            'first_name' => $request->firstname,
            'last_name' => $request->lastname,
            'telephone' => $request->telephone,
            'password' => Hash::make($request->password),
            'user_type' => 'enduser', // Default user type
        ]);

        return response(['message' => 'User registered successfully', 'user' => $user], 201);
    }

    public function login(Request $request)
    {
        $request->validate([
            'telephone' => 'required|string',
            'password' => 'required|string',
        ]);

        $user = User::where('telephone', $request->telephone)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response(['message' => 'Invalid credentials'], 401);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response(['message' => 'Login successful', 'token' => $token]);
    }
}
