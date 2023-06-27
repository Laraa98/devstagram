<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class PerfilController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function index(){
        return view('perfil.index');
    }

    public function store(Request $request){
        $request->request->add(['username' => Str::slug($request->username)]);

        $this->validate($request, [
            'username' => ['required', 'unique:users,username,'.auth()->user()->id, 'min:3', 'max:20', 'not_in:twitter']
        ]);

        if($request->imagen){
            $imagen = $request->file('imagen');
            $nombreImagen = Str::uuid().".".$imagen->extension(); //se renombra la imagen con un id unico que se genera con uuid y se le agrega la extension
            
            $imagenServidor = Image::make($imagen);
            $imagenServidor->fit(1000, 1000); //La imagen medira 1000px x 1000px
    
            $imagenPath = public_path('perfiles').'/'.$nombreImagen; // Se guardara en la carpeta public con su id
            $imagenServidor->save($imagenPath);
        }
        $usuario = User::find(auth()->user()->id);
        $usuario->username = $request->username;
        $usuario->imagen = $nombreImagen ?? auth()->user()->imagen ?? '';
        $usuario->save();

        return redirect()->route('posts.index', $usuario->username);
    }
}