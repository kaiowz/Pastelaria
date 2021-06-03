<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class UserController extends Controller
{
    private $loggedUser;

    public function __construct(){
        $this->middleware('auth:api', [
            'except' => [
                'create'
            ]
        ]);
        $this->loggedUser = auth()->user();
    }

    public function index($id = false){
        if (!$id){
            $users = User::all();
            return response()->json(['result' => $users], 200);
        }else{
            $user = User::find($id);
            if (!$user) return response()->json(['error'=>'Id inválido'], 400);
            return response()->json(['result' => $user], 200);
        }
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

        if (!$name && !$email && !$password &&
        !$passwordConfirmation && !$phone && !$birthdate &&
        !$address && !$neighborhood && !$cep) return response()->json(['error'=>'Você não preencheu todos os campos corretamente'], 400);

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
    }

    public function update(Request $req, $id){
        $name = trim($req->input('name'));
        $email = trim($req->input('email'));
        $password = $req->input('password');
        $passwordConfirmation =  $req->input('password_confirmation');
        $phone = $req->input('phone');
        $birthdate = $req->input('birthdate');
        $address = trim($req->input('address'));
        $addon = trim($req->input('addon'));
        $neighborhood = trim($req->input('neighborhood'));
        $cep = trim($req->input('cep'));

        $user = User::find($id);
        if (!$user) return response()->json(['error' => 'ID inválido'], 400);

        $emailExists = User::where('email', $email)->count();

        if ($emailExists != 0) return response()->json(['error'=>'E-mail já cadastrado'], 400);
        if ($password && !$this->isValidPassword($password)) return response()->json(['error'=>'A senha é muito fraca. Certifique-se de inserir pelo menos um caractere minúsculo, maiúsculo, especial e no mínimo 6 caracteres'], 400);
        if ($password != $passwordConfirmation) return response()->json(['error'=>'Senhas não coincidem'], 422);

        if ($name) $user->name = $name;
        if ($email) $user->email = $email;
        if ($password) $user->password = password_hash($password, PASSWORD_DEFAULT);
        if ($phone) $user->phone = $phone;
        if ($birthdate) $user->birthdate = $birthdate;
        if ($address) $user->address = $address;
        if ($addon) $user->addon = $addon;
        if ($neighborhood) $user->neighborhood = $neighborhood;
        if ($cep) $user->cep = $cep;
        $user->save();

        return response()->json(['result' => "Usuário atualizado com sucesso"], 200);
    }

    public function delete($id = false){
        $user = User::find($id);
        if (!$user) return response()->json(['error'=>"Id inválido"]);

        $user->isDeleted = true;
        $user->save();

        return response()->json(['result' => "Usuário deletado com sucesso"], 200);
    }

    private function isValidPassword($pass){
        return preg_match('/[a-z]/', $pass) // at least one lowercase char
        && preg_match('/[A-Z]/', $pass) // at least one uppercase char
        && preg_match('/[0-9]/', $pass) // at least one number
        && preg_match('/^[\w$@]{6,}$/', $pass); // at least six chars
    }
}
