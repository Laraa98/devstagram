<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class ImagenController extends Controller
{
    public function store(Request $request){
        $imagen = $request->file('file');
        $nombreImagen = Str::uuid().".".$imagen->extension(); //se renombra la imagen con un id unico que se genera con uuid y se le agrega la extension
        
        $imagenServidor = Image::make($imagen);
        $imagenServidor->fit(1000, 1000); //La imagen medira 1000px x 1000px

        $imagenPath = public_path('uploads').'/'.$nombreImagen; // Se guardara en la carpeta public con su id
        $imagenServidor->save($imagenPath);

        return response()->json(['imagen' => $nombreImagen]);
    }
}
