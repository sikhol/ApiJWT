<?php

use Tymon\JWTAuth\Exceptions\JWTException;
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;
use JWTAuth;

class AuthController extends Controller
{

  public function index()
  {
    $users= User::all();
    return $users;
  }

  public function show($id)
  {
    $users=User::find($id);
    return $users;
  }

    public function signup(Request $request)
    {
       $this->validate($request,[
         'name'=> 'required|unique:users',
         'email'=> 'required|unique:users',
         'password'=> 'required',

       ]);
       return User::create([
         'name'=> $request->json('name'),
         'email'=> $request->json('email'),
         'password'=> bcrypt($request->json('password'))

       ]);
    }
    public function signin(Request $request)
    {
      $this->validate($request,[
        'name'=> 'required', 'password'=> 'required',
      ]);

      // grab credentials from the request
        $credentials = $request->only('name', 'password');

        try {
            // attempt to verify the credentials and create a token for the user
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'invalid_credentials'], 401);
            }
        } catch (JWTException $e) {
            // something went wrong whilst attempting to encode the token
            return response()->json(['error' => 'could_not_create_token'], 500);
        }

        // all good so return the token
        return response()->json([
          'id_user' => $request->user()->id,
          'username'=> $request->user()->name,
          'token' => $token
        ]);


    }
}
