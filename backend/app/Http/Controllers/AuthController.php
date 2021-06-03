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
                'login', 'unauthorized', "create"
                ]
        ]);
    }

    public function unauthorized(){
       return response()->json(['result'=>'Você não está autorizado a acessar essa área'], 401);
    }

    public function login(Request $req){
        $email = $req->input('email');
        $password = $req->input('password');

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

    public function create(Request $req){
        $name = trim($req->input('name'));
        $email = trim($req->input('email'));
        $phone = trim($req->input('phone'));
        $password = $req->input('password');
        $passwordConfirmation = $req->input('password_confirmation');
        $birthdate = $req->input('birthdate');
        $address = trim($req->input('address'));
        $addon = trim($req->input('addon'));
        $neighborhood = trim($req->input('neighborhood'));
        $cep = trim($req->input('cep'));

        if ($name && $email && $password && $passwordConfirmation && $phone &&
        $birthdate && $address && $neighborhood && $cep){
            $emailExists = User::where('email', $email)->count();

            if ($emailExists != 0) return response()->json(['error'=>'E-mail já cadastrado'], 422);
            if (!$this->isValidPassword($password)) return response()->json(['error'=>'A senha é muito fraca. Certifique-se de inserir pelo menos um caractere minúsculo, maiúsculo, especial e no mínimo 6 caracteres'], 422);
            if ($password != $passwordConfirmation) return response()->json(['error'=>'Senhas não coincidem'], 422);

            $hash = password_hash($password, PASSWORD_DEFAULT);
            $newUser = new User();
            $newUser->name = $name;
            $newUser->email = $email;
            $newUser->password = $hash;
            $newUser->phone = $phone;
            $newUser->birthdate = $birthdate;
            $newUser->address = $address;
            $newUser->addon = $addon;
            $newUser->neighborhood = $neighborhood;
            $newUser->cep = $cep;
            $newUser->save();

            $token = Auth::attempt(['email'=>$email, 'password'=>$password]);

            if (!$token) return response()->json(['error'=>'Ocorreu um erro interno!'], 500);

            return response()->json(['token'=>$token], 200);

        }else return response()->json(['error'=>'Você não preencheu todos os campos corretamente'], 400);
    }

    private function isValidPassword($pass){
        return preg_match('/[a-z]/', $pass) // at least one lowercase char
        && preg_match('/[A-Z]/', $pass) // at least one uppercase char
        && preg_match('/[0-9]/', $pass) // at least one number
        && preg_match('/^[\w$@]{6,}$/', $pass); // at least six chars
    }
}
