<?php

namespace LinkApp\Http\Controllers\Auth;

use LinkApp\Models\ERP\Usuario;
use LinkApp\Models\ERP\Persona;
use LinkApp\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

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
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /** override funtion for change view redirect */

    public function showRegistrationForm()
    {
        return view('temes.inspinia.auth.register');
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
            'username' => ['required', 'string', 'max:30'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:usuario'],
            'password' => ['required', 'string', 'min:4', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \LinkApp\User
     */
    protected function create(array $data)
    {
        $persona = new Persona();

        $persona->cedula =  $data['cedula'];
        $persona->nombre =  $data['nombre'];
        $persona->img = '';
        $persona->alias = '';
        $persona->idTipoPersona = '1';
        $persona->idEstado = '1';
        $persona->save();

        $idPersona = Persona::Where('cedula',$data['cedula'])->first();

        return Usuario::create([
            'username' => $data['username'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'idPersona' => $idPersona->id,
            'idEstado' => '1',
        ]);
    }
}
