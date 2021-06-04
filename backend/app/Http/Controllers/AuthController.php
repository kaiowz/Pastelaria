<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    public function __construct(){
        $this->middleware('auth:api', [
            'except' => [
                'login', 'unauthorized'
                ]
        ]);
    }

    public function unauthorized(){
       return response()->json(['result'=>'Você não está autorizado a acessar essa área'], 401);
    }

    public function login(Request $req){
        $email = $req->input('email');
        $password = $req->input('password');

        $loginUser = User::where('email', $email)->first();
        if (!$loginUser) return response()->json(['error'=>'E-mail e/ou senha errados!'], 400);
        if ($loginUser->isDeleted) return response()->json(['error'=>'Sua conta foi deletada e não pode ser acessada. Entre em contato com o suporte para mais informações!'], 422);

        if ($email && $password){
            $token = Auth::attempt(['email'=>$email, 'password'=>$password]);

            if (!$token) return response()->json(['error'=>'E-mail e/ou senha errados!'], 422);

            return response()->json(['token'=>$token], 200);
        } else return response()->json(['error'=> "Preencha os campos correntamente"], 400);
    }

    public function logout(){
        Auth::logout();
        return response()->json(['result'=>'Logout realizado'], 200);
    }

    public function refresh(){
        $token = Auth::refresh();
        return response()->json(['token'=>$token], 200);
    }
}
