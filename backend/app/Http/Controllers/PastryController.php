<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pastry;
use Image;

class PastryController extends Controller
{
    public function index($id = false){
        if (!$id){
            $pastries = Pastry::where('isDeleted', false)->get();
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

        $allowedTypes = ['image/jpg', 'image/jpeg', 'image/png'];

        $photo = $req->file('photo');

        if (!$name && !$price && !$photo) return response()->json(['error' => 'Preencha os campos corretamente'], 400);

        if (!in_array($photo->getClientMimeType(), $allowedTypes)) return response()->json(['error' => 'Arquivo não suportado'], 400);

        $filename = md5(time().rand(0, 9999)).'.jpg';
        $destPath = public_path('/assets');

        Image::make($photo->path())->fit(300, 300)->save("$destPath/$filename");

        $newPastry = new Pastry();
        $newPastry->name = $name;
        $newPastry->price = $price;
        $newPastry->photo = $filename;
        $newPastry->save();

        return response()->json(['result' => "Pastel criado com sucesso"], 200);
    }

    public function update(Request $req, $id){
        $name = trim($req->input('name'));
        $price = floatval($req->input('price'));

        $allowedTypes = ['image/jpg', 'image/jpeg', 'image/png'];

        $photo = $req->file('photo');

        $pastry = Pastry::find($id);
        if (!$pastry) return response()->json(['error' => 'ID inválido'], 400);

        if ($name) $pastry->name = $name;
        if ($price) $pastry->price = $price;
        if ($photo) {
            if (!in_array($photo->getClientMimeType(), $allowedTypes)) return response()->json(['error' => 'Arquivo não suportado'], 400);

            $filename = md5(time().rand(0, 9999)).'.jpg';
            $destPath = public_path('/media/assets');

            Image::make($photo->path())
                ->fit(300, 300)
                ->save("$destPath/$filename");

                $pastry->photo = $filename;
        }

        $pastry->save();

        return response()->json(['result' => "Pastel atualizado com sucesso"], 200);
    }

    public function delete($id = false){
        $pastry = Pastry::find($id);
        if (!$pastry) return response()->json(['error'=>"Id inválido"], 400);

        $pastry->isDeleted = true;
        $pastry->save();

        return response()->json(['result' => "Pastel deletado com sucesso"], 200);
    }

    public function restore($id){
        $pastry = Pastry::find($id);
        if (!$pastry) return response()->json(['error'=>"Id inválido"], 400);

        $pastry->isDeleted = false;
        $pastry->save();

        return response()->json(['result' => "Pastel restaurado com sucesso"], 200);
    }
}
