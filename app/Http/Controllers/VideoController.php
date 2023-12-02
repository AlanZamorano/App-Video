<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use App\Models\Video;
use App\Models\Categoria;
use App\Models\User;
use App\Models\Comentario;
use App\Models\Reaccion;

class VideoController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function create(){
        $categorias = Categoria::all();
        return view('video.create', ['categorias' => $categorias]);
    }

    public function categorias(){
        $categorias = Categoria::orderBy('id', 'asc')->get();
        return view('categorias.create', ['categorias' => $categorias]);
    }

    public function createCategorias(Request $request){
        $validate = $request->validate([
            'tipo' =>['required', 'regex:/^[A-Za-z0-9\s]+$/u', 'max:80']
        ]);

        $tipo = $request->input('tipo');

        $categoria = new Categoria();
        $categoria->tipo = $tipo;

        $categoria->save();

        return redirect()->route('categorias.create')
        ->with(['message' => 'Categoria creada correctamente']);
    }

    public function editCategorias($id){
        $user = \Auth::user();
        $categorias = Categoria::find($id);

        if($user->tipo_usuario_id == 1){
            return view('categorias.edit', [
                'categorias' => $categorias
            ]);
        }
        else{
            return redirect()->route('categorias.create');
        }
    }

    public function updateCategorias(Request $request){
        $validate = $this->validate($request, [
            'tipo' => ['required', 'max:80', 'regex:/^[A-Za-z0-9\s]+$/u'],
        ]);
    
        // obtener valores del formulario
            $id = $request->input('id');
            $tipo = $request->input('tipo');
    
            // datos a actualizar
            $categoria = Categoria::find($id);
            $categoria->tipo = $tipo;
           
            // metodo para actualizar
            $categoria->update();
    
            return redirect()->route('categorias.create', ['id' => $id])
            ->with(['message' => 'Categoria actualizada correctamente']);
        
             console.log($categoria->id);
    }

    public function save(Request $request){
        // Valida los datos del formulario
        $validate = $request->validate([
            'video' => ['required', 'mimes:mp4,avi,mov', 'max:5000'],
            'titulo' => ['required', 'max:150', 'regex:/^[A-Za-z0-9\s]+$/u'],
            'descripcion' => ['nullable', 'regex:/^[A-Za-z0-9\s]+$/u'],
            'miniatura' => ['required', 'image'],
            'categoria_id' => ['required', 'exists:categoria,id']
        ]);
     
        // Tomar valores de input
        $videoURL = $request->file('video');
        $titulo = $request->input('titulo');
        $descripcion = $request->input('descripcion');
        $miniatura = $request->file('miniatura');
        $categoria_id = $request->input('categoria_id');

        // asignar valores al objeto de video
        $user = \Auth::user();
        $canal = $user->canal;
        $video = new Video();
        $video->canal_id = $canal->id;
        $video->titulo = $titulo;
        $video->descripcion = $descripcion;
        $video->categoria_id = $categoria_id;
        $video->estado_id = 3;
        $video->vistas = 0;

        //si el video cumple con las validaciones entonces se subirá
        if($videoURL){
            $videoC = time().$videoURL->getClientOriginalName();
            Storage::disk('videos')->put($videoC, File::get($videoURL));
            $video->video = $videoC;
        }
        else{
            echo "No lo haga";
        }

        //si la imagen cumple con las validaciones entonces se subirá
        if ($miniatura) {
            $imagenN = time() . $miniatura->getClientOriginalName();
            Storage::disk('imagenes')->put($imagenN, File::get($miniatura));
            $video->miniatura = $imagenN; 
        } else {
            $video->miniatura = 'icono.jpg';
        }
        $video->save();

        return redirect()->route('canal.profileP', ['id' => $canal->id])->with([
            'message' => 'Video subido correctamente un administrador revisará tu video para determinar si cumple con nuestras normas establecidas'
        ]);
    }

    // mostrar la miniatura del video
    public function getImagen($filename)
    {
        $file = Storage::disk('imagenes')->get($filename);
        return new Response($file, 200);
    }

    // mostrar el video
    public function getVideo($filename)
    {
        $file = Storage::disk('videos')->get($filename);
        return new Response($file, 200);
    }

    // Detalles del video e incremento de vistas
    public function detail($id){
       
        $video = Video::find($id);
        if ($video) {
            $video->increment('vistas');
        }
        return view('video.detail', [
            'video' => $video
        ]);
    }

    public function detailInactivo($id){
       
        $video = Video::find($id);

        return view('video.detailI', [
            'video' => $video
        ]);
    }    
    
    // funcion para eliminar los videos
    public function delete($id){
        // llama a los datos del usuario autenticado
        $user = \Auth::user();
        // busqueda de video por id
        $video = Video::find($id);
        // busca las reacciones del video
        $reaccion = Reaccion::where('video_id', $id)->get();
        // busca los comentarios del video
        $comentario = Comentario::where('video_id', $id)->get();

        if($user && $video && $video->canal->users_id == $user->id){
            // borrar comentarios
            if($comentario && count($comentario) >= 1){
                foreach($comentario as $coment){
                    $coment->delete();
                }
            }
            // borrar reaccion
            if($reaccion && count($reaccion) >= 1){
                foreach($reaccion as $reac){
                    $reac->delete();
                }
            }
            // eliminar miniarura
            Storage::disk('imagenes')->delete($video->miniatura);
            // eliminar video
            Storage::disk('videos')->delete($video->video);
            // eliminar todo
            $video->delete();
            
            $estado = $video->estado_id;
            if($estado == 1){
                return redirect()->route('canal.profileA', ['id' => $video->canal_id])->with([
                    'message' => 'El video se borró correctamente'
                ]);
            }
            elseif($estado == 2){
                return redirect()->route('canal.profileI', ['id' => $video->canal_id])->with([
                    'message' => 'El video se borró correctamente'
                ]);
            }
            else{
                return redirect()->route('canal.profileP', ['id' => $video->canal_id])->with([
                    'message' => 'El video se borró correctamente'
                ]);
            }

            
        }
        else{
            return view('error');
        }
        
    }

    // Administrador
    public function rechazado($id)
    {
        $video = Video::find($id);
        $video->estado_id = 2;
        $video->save();
        return redirect()->route('admin.home')->with(['message' => 'Video rechazado']);
    }

    public function aceptado($id)
    {
        $video = Video::find($id);
        $video->estado_id = 1;
        $video->save();
        return redirect()->route('admin.home')->with(['message' => 'Video aceptado']);
    }

    public function detailA($id){
       
        $video = Video::find($id);
        
        return view('video.detailA', [
            'video' => $video
        ]);
    }

    public function edit($id){
        $user = \Auth::user();
        $video = Video::find($id);
        $categorias = Categoria::all();

        if($user->canal->users_id == $video->canal->users_id){
            return view('video.edit', [
                'video' => $video,
                'categorias' => $categorias
            ]);
        }
        else{
            return redirect()->route('home');
        }
    }

    public function videoUpdate(Request $request){
        // validacion del formulario
    $validate = $this->validate($request, [
        'titulo' => ['required', 'max:150', 'regex:/^[A-Za-z0-9\s]+$/u'],
        'descripcion' => ['nullable', 'regex:/^[A-Za-z0-9\s]+$/u'],
        'categoria_id' => ['required', 'exists:categoria,id']
    ]);

    // obtener valores del formulario
        $id = $request->input('id');
        $titulo = $request->input('titulo');
        $descripcion = $request->input('descripcion');
        $categoria = $request->input('categoria_id');

        // datos a actualizar
        $video = Video::find($id);
        $video->titulo = $titulo;
        $video->descripcion = $descripcion;
        $video->categoria_id = $categoria;

       
        // metodo para actualizar
        $video->update();

        return redirect()->route('video.detail', ['id' => $id])
        ->with(['message' => 'Video actualizado correctamente']);
    }
}






