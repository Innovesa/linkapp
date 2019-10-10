<?php

namespace LinkApp\Http\Controllers\Auth;

use LinkApp\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use LinkApp\Models\ERP\Estructura;
use LinkApp\Models\ERP\PerfilUsuario;
use LinkApp\Models\ERP\PerfilOpcion;
use LinkApp\Models\ERP\Menu;


class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
  

     //protected $redirectTo = 'home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }


    public function showLoginForm()
    {
        return view('temes.inspinia.auth.login');
    }

 
    protected function credentials(Request $request)
    {
        $field = $this->field($request);

        return [
            $field => $request->get($this->username()),
            'password' => $request->get('password'),
        ];

    }

    public function field(Request $request)
    {
        $email = $this->username();

        return filter_var($request->get($email), FILTER_VALIDATE_EMAIL) ? $email : 'username';
    }

    protected function validateLogin(Request $request)
    {
         $field = $this->field($request);

        $messages = ["{$this->username()}.exists" => 'The account you are trying to login is not registered or it has been disabled.'];

        $this->validate($request, [
            $this->username() => "required|exists:usuario,{$field}",
            'password' => 'required',
        ], $messages);
    }

    //Redireccionamiento de la ruta
    protected function redirectTo()
    {
        $user = \Auth::User();
        $perfil = PerfilUsuario::where('idUsuario',$user->id)->first();
        
        if($perfil == null){

            return route('usuario.verificacion.perfil');

        }else{
            
            $perfilOpcion = PerfilOpcion::where('idPerfil',$perfil->idPerfil)->get();
            if($perfilOpcion != null){
                
                 return '/home';
                 
            }else{
                return route('usuario.verificacion.perfil');
            }
        }
    }
    
    public function redirectPath()
    {
    	if ( method_exists($this, 'redirectTo') ) {
    		return $this->redirectTo();
    	} else {
    		return property_exists($this, 'redirectTo') ? $this->redirectTo : '/asdasdasdasd';
    	}
    }
}
