<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use JWTAuth;


class ApiController extends Controller
{

    public function getUserFromToken()
    {
        // this will set the token on the object
        JWTAuth::parseToken();

        // and you can continue to chain methods
        $user = JWTAuth::parseToken()->authenticate();

        return $user;
    }
}
