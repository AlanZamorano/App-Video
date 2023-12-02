<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;


class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],         
            'apellido_p' => ['required', 'string', 'max:60'],
            'apellido_m' => ['string', 'max:60'],
            'telefono' => ['digits:10'],
            'imagen' => ['image', 'max:2048'],
        ]);
    }
        

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        // si existe la imagen agregara un nombre unico y se guardara en la carpeta 
        // temporal para las imagenes de users
        if (isset($data['imagen'])) {
            $imagen = time() . $data['imagen']->getClientOriginalName();
            Storage::disk('users')->put($imagen, File::get($data['imagen']));
        } else {
            // Ruta de la imagen predeterminada en caso de que no se proporcione una imagen
            $imagen = '1690917457icono.jpg';
        }

        // Manda a llamar los datos del los input
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'apellido_p' => $data['apellido_p'],
            'apellido_m' => $data['apellido_m'],
            'telefono' => $data['telefono'],
            'imagen' => $imagen,
            'tipo_usuario_id' => $data['tipo_usuario_id'] = 2,
        ]);
    }
}
