<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Video;
use App\Models\Comentario;
use App\Models\User;

class AdminHomeController extends Controller
{
    public function index()
    {
        $videos = Video::orderBy('id', 'desc')->where('estado_id', 3)->paginate(9);

        return view('homeAdmin', [
            'videos' => $videos
        ]);
    }

    public function usuarios(){
        $usuarios = User::orderBy('id', 'asc')->paginate(10);

        return view('admin.usuarios', [
            'usuarios' => $usuarios
        ]);
    }

    public function aceptado()
    {
        $videos = Video::orderBy('id', 'desc')->where('estado_id', 1)->paginate(9);

        return view('admin.videoA', [
            'videos' => $videos
        ]);
    }

    public function comentarios(){
        $comentarios = Comentario::orderBy('id', 'asc')->where('estado_id', '3')->get();
        return view('admin.comentarios', [
            'comentarios' => $comentarios
        ]);
    }

    public function comentariosA(){
        $comentarios = Comentario::orderBy('id', 'asc')->where('estado_id', '1')->get();
        return view('admin.comentariosA', [
            'comentarios' => $comentarios
        ]);
    }

    public function estadoUsuario($id){
        // Obtiene al usuario autenticado
        $user = \Auth::user();
        //  Busca al usuario con el id proporcionado
        $usuario = User::find($id);

        // Verifica si el usuario esta autenticado y es un administrador y si encontró un usuario con el id dado
        if ($user && $user->tipo_usuario_id === 1 && $usuario) {
            // Cambia el usuario segun su estado actual
            if ($usuario->estado_id === 1) {
                $usuario->estado_id = 2;
                $usuario->save();
                return redirect()->route('admin.usuarios')->with([
                    'message' => 'El usuario ha sido desactivado'
                ]);
            } elseif ($usuario->estado_id === 2) {
                $usuario->estado_id = 1;
                $usuario->save();
                return redirect()->route('admin.usuarios')->with([
                    'message' => 'El usuario ha sido activado'
                ]);
            } elseif ($usuario->estado_id === 3){
                $usuario->estado_id = 1;
                $usuario->save();
                return redirect()->route('admin.usuarios')->with([
                    'message' => 'El usuario ha sido activado'
                ]);
            }
        }

        return redirect()->back()->with([
            'error' => 'No se pudo cambiar el estado del usuario'
        ]);
    }

}
