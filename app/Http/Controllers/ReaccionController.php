<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reaccion;
use Illuminate\Support\Facades\DB;


class ReaccionController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function like($video_id){
        // recoger datos del usuario y el video
        $user = \Auth::user();

        // condicion para ver si ya existe el like
        $valida = Reaccion::where('users_id', $user->id)->where('video_id', $video_id)->count();

        if($valida == 0){
        $like = new Reaccion();
        $like->tipo_reaccion_id = 1;
        $like->users_id = $user->id;
        $like->video_id = (int)$video_id;

        // Guardar
        $like->save();

        return response()->json([
            'like' => $like
        ]);
        }
        else{
            return response()->json([
                'message' => 'No puedes reaccionar nuevamente'
            ]);
        }
    }

    public function likeDelete($video_id){
         // recoger datos del usuario y el video
        $user = \Auth::user();

         // condicion para ver si ya existe el like
        $like = Reaccion::where('users_id', $user->id)->where('video_id', $video_id)->first();
 
        if($like){
        
        $like->delete();
 
        return response()->json([
            'like' => 'No me gusta'
        ]);
        }
        else{
            return response()->json([
                'message' => 'No existe el like'
            ]);
        }
    }

    // Funciones para el no me gusta
    public function dislike($video_id){
        // recoger datos del usuario y el video
        $user = \Auth::user();

        // condicion para ver si ya existe el like
        $valida = Reaccion::where('users_id', $user->id)->where('video_id', $video_id)->count();

        if($valida == 0){
        $dislike = new Reaccion();
        $dislike->tipo_reaccion_id = 2;
        $dislike->users_id = $user->id;
        $dislike->video_id = (int)$video_id;

        // Guardar
        $dislike->save();

        return response()->json([
            'dislike' => $dislike
        ]);
        }
        else{
            return response()->json([
                'message' => 'No puedes reaccionar nuevamente'
            ]);
        }
    }

    public function dislikeDelete($video_id){
         // recoger datos del usuario y el video
        $user = \Auth::user();

         // condicion para ver si ya existe el like
        $dislike = Reaccion::where('users_id', $user->id)->where('video_id', $video_id)->first();
 
        if($dislike){
        
        $dislike->delete();
 
        return response()->json([
            'dislike' => 'No me gusta'
        ]);
        }
        else{
            return response()->json([
                'message' => 'No existe el like'
            ]);
        }
    }

    public function favorites(){
        $user = \Auth::user();
        $likes  = Reaccion::orderBy('id', 'desc')->where('tipo_reaccion_id', 1)
        ->where('users_id', $user->id)->paginate(9);
    
        return view('reacciones.likes', [
            'likes' => $likes
        ]);
    }
}
