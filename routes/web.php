<?php

use Illuminate\Support\Facades\Route;
use App\Models\Video;
use App\Models\User;
use App\Models\Canal;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

// Usuario
Route::get('/configuracion', [App\Http\Controllers\UserController::class, 'config'])->name('config');
Route::post('/usuario/actualizar', [App\Http\Controllers\UserController::class, 'update'])->name('user.update');
Route::get('/usuario/imagen/{filename}', [App\Http\Controllers\UserController::class, 'getImagen'])->name('user.imagen')->withoutMiddleware('auth');

// Home
Route::get('/', [App\Http\Controllers\HomeController::class, 'index', 'top'])->name('home');
Route::get('/top-videos', [App\Http\Controllers\HomeController::class, 'getTopVideos'])->name('videos.top');
// Admin
Route::get('/home', [App\Http\Controllers\AdminHomeController::class, 'index'])->name('admin.home')->middleware('admin');
Route::get('/video-aceptado/admin', [App\Http\Controllers\AdminHomeController::class, 'aceptado'])->name('admin.videoA')->middleware('admin');
Route::get('/comentarios-pendientes/admin', [App\Http\Controllers\AdminHomeController::class, 'comentarios'])->name('admin.comentarios')->middleware('admin');
Route::get('/comentarios-aceptados/admin', [App\Http\Controllers\AdminHomeController::class, 'comentariosA'])->name('admin.comentariosA')->middleware('admin');

// Video
Route::get('/subir-video', [App\Http\Controllers\VideoController::class, 'create'])->name('video.create');
Route::post('/video/guardar', [App\Http\Controllers\VideoController::class, 'save'])->name('video.save');
Route::get('/video/{id}', [App\Http\Controllers\VideoController::class, 'detail'])->name('video.detail')->withoutMiddleware('auth');
Route::get('/video-on/{id}', [App\Http\Controllers\VideoController::class, 'detailInactivo'])->name('video.detailI');
Route::get('/video/miniatura/{filename}', [App\Http\Controllers\VideoController::class, 'getImagen'])->name('video.imagen')->withoutMiddleware('auth');
Route::get('/video/video/{filename}', [App\Http\Controllers\VideoController::class, 'getVideo'])->name('video.video')->withoutMiddleware('auth');
Route::get('/video/borrar/{id}', [App\Http\Controllers\VideoController::class, 'delete'])->name('video.delete');
Route::get('/video/editar/{id}', [App\Http\Controllers\VideoController::class, 'edit'])->name('video.edit');
Route::post('/video/update', [App\Http\Controllers\VideoController::class, 'videoUpdate'])->name('video.update');

// Categorias
Route::post('/categoria/guardar', [App\Http\Controllers\VideoController::class, 'createCategorias'])->name('categorias.save')->middleware('admin');
Route::get('/categorias', [App\Http\Controllers\VideoController::class, 'categorias'])->name('categorias.create')->middleware('admin');
Route::post('/categoria/editar', [App\Http\Controllers\VideoController::class, 'updateCategorias'])->name('categorias.update')->middleware('admin');
Route::get('/categoria/actualizar/{id}', [App\Http\Controllers\VideoController::class, 'editCategorias'])->name('categorias.edit')->middleware('admin');

// Admin
Route::get('/video/rechazado/{id}', [App\Http\Controllers\VideoController::class, 'rechazado'])->name('video.rechazado')->middleware('admin');
Route::get('/video/aceptado/{id}', [App\Http\Controllers\VideoController::class, 'aceptado'])->name('video.aceptado')->middleware('admin');
Route::get('/video/admin/{id}', [App\Http\Controllers\VideoController::class, 'detailA'])->name('video.detailA')->middleware('admin');
Route::get('/usuarios', [App\Http\Controllers\AdminHomeController::class, 'usuarios'])->name('admin.usuarios')->middleware('admin');
Route::post('/admin/usuarios/{id}/estado', [App\Http\Controllers\AdminHomeController::class, 'estadoUsuario'])->name('admin.usuariosEstado')->middleware('admin');


// Canal
Route::get('/crear-canal', [App\Http\Controllers\CanalController::class, 'create'])->name('canal.create');
Route::post('/canal/guardar', [App\Http\Controllers\CanalController::class, 'save'])->name('canal.save');
Route::post('/canal/actualizar', [App\Http\Controllers\CanalController::class, 'update'])->name('canal.update');
Route::get('/canal/imagen/{filename}', [App\Http\Controllers\CanalController::class, 'getImagen'])->name('canal.imagen')->withoutMiddleware('auth');
Route::get('/canal/configuracion', [App\Http\Controllers\CanalController::class, 'config'])->name('canal.config');
Route::get('/canal/{id}', [App\Http\Controllers\CanalController::class, 'profile'])->name('canal.profile')->withoutMiddleware('auth');
Route::get('/canal/videos-aceptados/{id}', [App\Http\Controllers\CanalController::class, 'profileAceptado'])->name('canal.profileA');
Route::get('/canal/videos-inactivos/{id}', [App\Http\Controllers\CanalController::class, 'profileInactivo'])->name('canal.profileI');
Route::get('/canal/videos-pendientes/{id}', [App\Http\Controllers\CanalController::class, 'profilePendiente'])->name('canal.profileP');
Route::get('/canales/{search?}', [App\Http\Controllers\CanalController::class, 'index'])->name('canal.index')->withoutMiddleware('auth');

// Comentario
Route::post('/comentario/guardar', [App\Http\Controllers\ComentarioController::class, 'save'])->name('comentario.save');
Route::get('/comentario/borrar/{id}', [App\Http\Controllers\ComentarioController::class, 'delete'])->name('comentario.delete');
// Administrador
Route::get('/comentarioA/borrar/{id}', [App\Http\Controllers\ComentarioController::class, 'deleteA'])->name('comentario.deleteA')->middleware('admin');
Route::get('/comentario/pendiente/{id}', [App\Http\Controllers\ComentarioController::class, 'pendiente'])->name('comentario.pendiente')->middleware('admin');
Route::get('/comentario/aceptado/{id}', [App\Http\Controllers\ComentarioController::class, 'aceptado'])->name('comentario.aceptado')->middleware('admin');
Route::get('/comentario/eliminado/{id}', [App\Http\Controllers\ComentarioController::class, 'deletec'])->name('comentario.eliminado')->middleware('admin');

// Reaccion
Route::get('/reaccion/like/{video_id}', [App\Http\Controllers\ReaccionController::class, 'like'])->name('reaccion.like');
Route::get('/reaccion/borrar-like/{video_id}', [App\Http\Controllers\ReaccionController::class, 'likeDelete'])->name('reaccion.likeDelete');
Route::get('/reaccion/dislike/{video_id}', [App\Http\Controllers\ReaccionController::class, 'dislike'])->name('reaccion.dislike');
Route::get('/reaccion/borrar-dislike/{video_id}', [App\Http\Controllers\ReaccionController::class, 'dislikeDelete'])->name('reaccion.dislikeDelete');
Route::get('/videos-favoritos', [App\Http\Controllers\ReaccionController::class, 'favorites'])->name('reaccion.favorites');

Route::fallback(function () {
    return view('error'); // Cambia 'errors.not-found' por la vista que quieras mostrar
});
