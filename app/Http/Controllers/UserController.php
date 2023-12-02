<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;


class UserController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

        public function config() {
            $user = \Auth::user();
        
            return view('user.config');
        }

    public function update(Request $request){
        // Identificar usuario
        $user = \Auth::user();

        // Validacion del formulario
        $validate = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,'.$user->id],     
            'apellido_p' => ['required', 'string', 'max:60'],
            'apellido_m' => ['string', 'max:60'],
            'telefono' => ['digits:10'],
            'imagen' => ['image']
        ]);

        // obtener valores de los input del formulario
        $user->name = $request->input('name');
        $user->apellido_p = $request->input('apellido_p');
        $user->apellido_m = $request->input('apellido_m');
        $user->telefono = $request->input('telefono');

        // obtener imagen
        $user->imagen = $request->file('imagen');
        if($user->imagen){
            $imagen = time().$user->imagen->getClientOriginalName();
            Storage::disk('users')->put($imagen, File::get($user->imagen));
            $user->imagen = $imagen;
        }
        else {
            // Ruta de la imagen predeterminada en caso de que no se proporcione una imagen
            $user->imagen = '1690917457icono.jpg';
        }

        // ejecutar consultas y cambios en la db
        $user->update();
        return redirect()->route('config')->with(['message' => 'Usuario actualizado correctamente']);
    }

    public function getImagen($filename){
        $file = Storage::disk('users')->get($filename);
        return new Response($file, 200);
    }

    
}
