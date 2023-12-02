<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = RouteServiceProvider::HOME;

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    // Sobreescribir el método para redirigir según el tipo de usuario
    protected function authenticated(Request $request, $user)
    {
        if ($user->tipo_usuario_id == 1) {
            return redirect()->route('admin.home');
        } elseif ($user->tipo_usuario_id == 2) {
            return redirect()->route('home');
        } else {
            return redirect()->intended($this->redirectPath());
        }
    }
}
