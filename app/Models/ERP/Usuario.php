<?php

namespace LinkApp\Models\ERP;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use LinkApp\Notifications\MailResetPasswordNotification as MailResetPasswordNotification;
use LinkApp\Notifications\MailAccountVerification as MailAccountVerification;
use Illuminate\Support\Facades\DB;


class Usuario extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;

    protected $table = 'usuario';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'email', 'password','idPersona','idEstado'
        
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    //Relaciones

    //many to one 
    public function persona(){
        return $this->belongsTo('LinkApp\Models\ERP\Persona','idPersona'); 
    }

    //many to one
    public function estado(){
         return $this->belongsTo('LinkApp\Models\ERP\Estado','idEstado'); 
           
    }

     //one to many
    public function perfilUsuario(){
        return $this->hasMany('LinkApp\Models\ERP\PerfilUsuario','idUsuario');
    }
 /////////////////////////////////////////////////////

 //Override para los correos de verificacion y cambio de password
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new MailResetPasswordNotification($token));
    }

    public function sendEmailVerificationNotification()
    {
        $this->notify(new MailAccountVerification);
    }

 /////////////////////////////////////////////////////

 public function getPermisos($user,$compania){

    $permisos = DB::table('perfil_opcion')
    ->distinct()
    ->join('perfil', 'perfil.id', '=', 'perfil_opcion.idPerfil')
    ->join('perfil_usuario', 'perfil_usuario.idPerfil', '=', 'perfil.id')
    ->join('opcion', 'opcion.id', '=', 'perfil_opcion.idOpcion')
    ->select('opcion.nombre','opcion.accion', 'perfil_opcion.*')
    ->where('perfil_usuario.idUsuario','=',$user->id)
    ->where('perfil_usuario.idCompania','=',$compania->id)
    ->get();


    return $permisos;
      
}

//trae personas mediante el rol o no 
public function getUsuario($buscar,$Compania,$isSuper=null){

    if($Compania && !$isSuper){
        $whereCompania = $Compania->id;
    }else{
        $whereCompania = null;
    }


    $result = DB::table($this->table)
    ->join('persona', 'persona.id', '=', 'usuario.idPersona')
    ->join('compania_persona', 'persona.id', '=', 'compania_persona.idPersona')
    ->join('estado', 'usuario.idEstado', '=', 'estado.id')
    ->select('persona.*','estado.nombre as NombreEstado','estado.codigo','usuario.email','usuario.username','usuario.id as idUsuario')
    ->where(function ($query) use ($buscar){ 
        $query->where('persona.nombre','LIKE','%'.$buscar.'%')
        ->orWhere('usuario.username','LIKE','%'.$buscar.'%')
        ->orWhere('usuario.email','LIKE','%'.$buscar.'%');
    })
    ->where('compania_persona.idCompania','LIKE','%'.$whereCompania.'%')
    ->orderBy('usuario.idEstado', 'asc')
    ->orderBy('usuario.username', 'asc')
    ->get();
        


    return $result;
}

}
