<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comentario;

class ComentarioController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function save(Request $request){
        // Validacion
        $validate = $this->validate($request, [
            'video_id' => ['required'],
            'descripcion' => ['required', 'string']
        ]);

        // Obtener datos del formulario
        $user = \Auth::user();
        $video_id = $request->input('video_id');
        $descripcion = $request->input('descripcion');

        // asignar valores a nuevo objeto
        $comentario = new Comentario();
        $comentario->users_id = $user->id;
        $comentario->video_id = $video_id;
        $comentario->descripcion = $descripcion;
        $comentario->estado_id = 3;

        // Guardar en db
        $comentario->save();

        return redirect()->route('video.detail', ['id' => $video_id])
        ->with([
            'message' => 'Comentario enviado correctamente'
        ]);
    }

    public function delete($id){
        $user = \Auth::user();

        // Conseguir objeto del comentario
        $comentario = Comentario::find($id);

        // comprobar si es mi comentario
        if($user && ($comentario->users_id == $user->id || $comentario->video->id == $user->id)){
            $comentario->delete();
            return redirect()->route('video.detail', ['id' => $comentario->video->id])
        ->with([
            'message' => 'Comentario borrado correctamente'
        ]);
        }
        else{
            return redirect()->route('video.detail', ['id' => $comentario->video->id])
        ->with([
            'message' => 'Lo sentimos solo el propietario del comentario puede borrarlo'
        ]);
        }
    }

    public function deleteA($id){
        $user = \Auth::user();

        // Conseguir objeto del comentario
        $comentario = Comentario::find($id);

        // comprobar si es mi comentario
        if($user && $user->tipo_usuario_id === 1){
            $comentario->delete();
            return redirect()->route('video.detailA', ['id' => $comentario->video->id])
        ->with([
            'message' => 'Comentario borrado correctamente'
        ]);
        }
    }

    public function aceptado($id)
    {
        $comentarios = Comentario::find($id);
        $comentarios->estado_id = 1;
        $comentarios->save();
        return redirect()->route('admin.comentariosA')->with(['message' => 'Comentario aceptado']);
    }

    public function deletec($id){
        $user = \Auth::user();

        // Conseguir objeto del comentario
        $comentario = Comentario::find($id);

        // comprobar si es mi comentario
        if($user && $user->tipo_usuario_id === 1){
            $comentario->delete();
            if($comentario->estado_id === 3){
                return redirect()->route('admin.comentarios', ['id' => $comentario->id])->with([
                    'message' => 'Comentario borrado correctamente'
                ]);
            }
            elseif($comentario->estado_id === 1){
                return redirect()->route('admin.comentariosA', ['id' => $comentario->id])->with([
                    'message' => 'Comentario borrado correctamente'
                ]);
            }
            
        }
    }
}
