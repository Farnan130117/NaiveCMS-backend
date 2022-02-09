<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use function GuzzleHttp\Promise\all;

class AuthController extends Controller
{
    public function login(Request $request){

    }
    public function register(Request $request){

        return response()->json(['test'=>'ok']);
        //return $request->all();
    }
}
