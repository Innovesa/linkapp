@extends('temes.inspinia.auth.layouts.VerifyRestart')


@section('content')
<div class="lock-word animated fadeInDown">
    <span class="first-word">CUENTA</span><span>BlOQUEADA</span>
</div>
    <div class="middle-box text-center lockscreen animated fadeInDown">
        <div>
            <div class="m-b-md">
            <img alt="image" class="img-circle circle-border img-blocked" src="{{ route('usuario.avatar',['filename' => \Auth::User()->persona->img ]) }}">
            </div>
            <h3>{{\Auth::User()->persona->nombre}}</h3>
            <p>Su cuenta en estos momentos permanece bloqueada ya que no se tiene ningun perfil ligado a su cuenta.</p>
            <p>Porfavor contactar directamente con soporte o por correo electrónico para agregar un perfil a su cuenta.</p>
            <a class="m-t btn btn-primary" href="mailto:linkapp@innove.co.cr?Subject=Cuenta sin perfil">Enviar correo</a>
        </div>
    </div>
@endsection