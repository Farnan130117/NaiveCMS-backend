<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use function GuzzleHttp\Promise\all;
use Exception;
use Laravel\Passport\RefreshToken;
use Laravel\Passport\Token;

class AuthController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request){
        $validator = Validator::make($request->all(), [
            'email'    => 'required|email',
            'password' => 'required'
        ]);

        if ($validator->fails()) {
            return sendError('Validation Error.', $validator->errors(), 422);
        }
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user             = Auth::user();
            $success['name']  = $user->name;
            $success['access_token'] = $user->createToken('accessToken')->accessToken;

            return sendResponse($success, 'You are successfully logged in.');
        } else {
            return sendError('Unauthorised', ['error' => 'Unauthorised'], 401);
        }

        }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request){

        $validator =Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|min:6',
        ]);

        if ($validator->fails())
        {
            return sendError('Validation Error.', $validator->errors(), 422);
            /*
            return Response()->json([
                'message'=> 'validation error',
                'data'   =>$validator->errors()],422);
            */
            //or
            //return response(['errors'=>$validator->errors()->all()], 422);
        }

        try {
            $user= User::create([
                'name'   =>$request->name,
                'email'  =>$request->email,
                'password'=>Hash::make($request->password),
            ]);

            $reginfo['name']  = $user->name;
            $message          = 'A user has been successfully created.';
           //$reginfo['access_token'] = $user->createToken('accessToken')->accessToken;
            /*
            return Response()->json([
                'status'=>true,
                'message'=> 'User Registration Complete',
                'user' => $user,
                ],);
            */


        }catch (Exception $e){
            $reginfo['access_token'] = [];
            $message          = 'Unable to create a new user.';
           // return Response()->json(['message'=>$e->getMessage()],$e->getCode());

        }


        return sendResponse($reginfo, $message);
    }


    public function logout(Request $request){

        $logout_userinfo['name']=Auth::user()->name;
        auth()->user()->token()->revoke();
        $message = 'You are logged out.';
        return sendResponse($logout_userinfo, $message);
    }
}
