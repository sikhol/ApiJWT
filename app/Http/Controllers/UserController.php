<?php
// use Tymon\JWTAuth\Exceptions\JWTException;

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;

class UserController extends Controller
{
    public function show(Request $request)
    {
    $user=$request->user()->name;
      return $user;
    }
}
