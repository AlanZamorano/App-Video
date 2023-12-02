<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Models\Canal;
use App\Models\User;
use App\Models\Video;
use App\Models\Categoria;

class CanalController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index($search = null){
        if(!empty($search)){
            $canales = Canal::where('nombre', 'ilike', '%'.$search.'%')
            ->orderBy('id', 'desc')->paginate(6);
        }

        if(!empty($search)){
            $videos = Video::where('titulo', 'ilike', '%'.$search.'%')
            ->where('estado_id', 1)
            ->orWhere('categoria_id', 'ilike', '%'.$search.'%')
            ->orderBy('id', 'desc')->paginate(6);
        }
        else{
            $canales = Canal::orderBy('id', 'desc')->paginate(6);
            $videos = Video::orderBy('id', 'desc')->where('estado_id', '1')->paginate(6);
        }

        
    
        return view('canal.index', [
            'canales' => $canales,
            'videos' => $videos, 
            
        ]);
    }

    public function config()
    {
        $user = Auth::user();
        $canal = $user->canal;

        return view('canal.config', ['canal' => $canal]);
    }

    public function create()
    {
        return view('canal.create');
    }

    public function save(Request $request)
    {
        // Valida datos del formulario
        $validate = $request->validate([
            'nombre' => ['required', 'string', 'max:100'],
            'descripcion' => ['required'],
            'imagen' => ['image'],
        ]);

        // toma los datos de los input
        $nombre = $request->input('nombre');
        $descripcion = $request->input('descripcion');
        $imagen = $request->file('imagen');

        // dando los valores al objeto
        $user = \Auth::user();
        $canal = new Canal();
        $canal->users_id = $user->id;
        $canal->nombre = $nombre;
        $canal->descripcion = $descripcion;
        $canal->estado_id = 1;

        // valida si hay imagen
        if ($imagen) {
            $imagenN = time() . $imagen->getClientOriginalName();
            Storage::disk('imagenes')->put($imagenN, File::get($imagen));
            $canal->imagen = $imagenN; // Almacena la ruta del archivo en la base de datos
        } else {
            $canal->imagen = 'icono.jpg';
        }
        $canal->save();

        return redirect()->route('home')->with([
            'message' => 'Canal creado correctamente'
        ]);
    }

    public function update(Request $request)
    {
        $user = \Auth::user();
        $canal = $user->canal;

        // Validacion del formulario
        $validate = $request->validate([
            'nombre' => ['required', 'string', 'max:100'],
            'descripcion' => ['required'],
            'imagen' => ['image'],
        ]);

        // obtener datos del input
        $canal->nombre = $request->input('nombre');
        $canal->descripcion = $request->input('descripcion');

        // validar si existe imagen
        $imagen = $request->file('imagen');
        if ($imagen) {
            $imagenN = time() . $imagen->getClientOriginalName();
            Storage::disk('imagenes')->put($imagenN, File::get($imagen));
            $canal->imagen = $imagenN; // Almacena la ruta del archivo en la base de datos
        } else {
            $canal->imagen = 'icono.jpg';
        }

        $canal->update();
        return redirect()->route('canal.config')->with(['message' => 'Canal actualizado correctamente']);
    }

    public function getImagen($filename)
    {
        $file = Storage::disk('imagenes')->get($filename);
        return new Response($file, 200);
    }

    public function profile($id) {
        $canal = Canal::find($id);

    
    $videos = Video::orderBy('created_at', 'desc')->where('canal_id', $canal->id)
    ->where('estado_id', 1)->paginate(9);
        return view('canal.profile', [
            'canal' => $canal,
            'videos' => $videos
        ]);
    }

    public function profileAceptado($id) {
        $canal = Canal::find($id);

    if (!$canal) {
        return view('error');
    }

    
    $videos = Video::orderBy('created_at', 'desc')->where('canal_id', $canal->id)
    ->where('estado_id', 1)->paginate(9);
        return view('canal.profileA', [
            'canal' => $canal,
            'videos' => $videos
        ]);
    }
    

    public function profileInactivo($id) {
        $canal = Canal::find($id);

    if (!$canal) {
        return view('error');
    }

    
    $videos = Video::orderBy('created_at', 'desc')->where('canal_id', $canal->id)
    ->where('estado_id', 2)->paginate(9);
        return view('canal.profileI', [
            'canal' => $canal,
            'videos' => $videos
        ]);
    }
    

    public function profilePendiente($id) {
        $canal = Canal::find($id);

    if (!$canal) {
        return view('error');
    }

    
    $videos = Video::orderBy('created_at', 'desc')->where('canal_id', $canal->id)
    ->where('estado_id', 3)->paginate(9);
        return view('canal.profileP', [
            'canal' => $canal,
            'videos' => $videos
        ]);
    }

    
}
