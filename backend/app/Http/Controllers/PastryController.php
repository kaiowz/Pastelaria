<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pastry;

class PastryController extends Controller
{
    private $loggedUser;

    public function __construct(){
        $this->middleware('auth:api');
        $this->loggedUser = auth()->user();
    }

    public function index($id = false){
        if (!$id){
            $pastries = Pastry::all();
            return response()->json(['result' => $pastries], 200);
        }else{
            $pastry = Pastry::find($id);
            if (!$pastry) return response()->json(['error'=>'Id inválido'], 400);
            return response()->json(['result' => $pastry], 200);
        }
    }

    public function create(Request $req){
        $name = trim($req->input('name'));
        $price = floatval($req->input('price'));

        if (!$name && !$price) return response()->json(['error' => 'Preencha os campos corretamente'], 400);

        $newPastry = new Pastry();
        $newPastry->name = $name;
        $newPastry->price = $price;
        $newPastry->save();

        return response()->json(['result' => "Pastel criado com sucesso"], 200);
    }

    public function update(Request $req, $id){
        $name = trim($req->input('name'));
        $price = floatval($req->input('price'));

        $pastry = Pastry::find($id);
        if (!$pastry) return response()->json(['error' => 'ID inválido'], 400);

        if ($name) $pastry->name = $name;
        if ($price) $pastry->price = $price;

        $pastry->save();

        return response()->json(['result' => "Pastel atualizado com sucesso"], 200);
    }

    public function delete($id = false){
        $pastry = Pastry::find($id);
        if (!$pastry) return response()->json(['error'=>"Id inválido"]);

        $pastry->isDeleted = true;
        $pastry->save();

        return response()->json(['result' => "Pastel deletado com sucesso"], 200);
    }
}
