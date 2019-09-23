
<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>LinkApp | {{$nombreAplicacion}} </title>

    @include('temes.inspinia.includes.css')

</head>

<body>

    <div id="wrapper">

        <nav class="navbar-default navbar-static-side" role="navigation">
            <div class="slimScrollDiv">
                <ul class="nav metismenu" id="side-menu">
                    <li class="nav-header">
                        <div class="dropdown profile-element">
                                <img alt="image" class="img-circle" src="{{ route('usuario.avatar',['filename' => \Auth::User()->persona->img ]) }}">
                                <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                                <span class="clear"> <span class="block m-t-xs"> <strong class="font-bold">{{\Auth::User()->persona->nombre}}</strong>
                                 </span> <span class="text-muted text-xs block">Perfil <b class="caret"></b></span> </span> </a>
                                <ul class="dropdown-menu animated fadeInRight m-t-xs">
                                    <li><a href="#">Cambiar compañía</a></li>
                                    <li><a href="#">Editar</a></li>
                                    <li class="divider"></li>
                                    <li><a href="#">Salir</a></li>
                                </ul>
                        </div>
                        <div class="logo-element">
                            LA
                        </div>
                    </li>
                    
                    @if (isset($_SESSION['menu']['contextual']))

                        @for ($i = 0; $i < count($_SESSION['menu']['contextual'][$nombreAplicacion]['superior']['id']); $i++)
                            @php
                               $id = $_SESSION['menu']['contextual'][$nombreAplicacion]['superior']['id'][$i];
                            @endphp
                            <li>
                                <a href="#"><i class="{{$_SESSION['menu']['contextual'][$nombreAplicacion]['superior']['icono'][$i]}}"></i> <span class="nav-label">{{$_SESSION['menu']['contextual'][$nombreAplicacion]['superior']['nombre'][$i]}}</span></a>
                               
                                <ul class="nav nav-second-level collapse" aria-expanded="true">
                                    @for ($j = 0; $j <  count($_SESSION['menu']['contextual'][$nombreAplicacion]['opcion']['id']); $j++)
                                        @if ($id == $_SESSION['menu']['contextual'][$nombreAplicacion]['opcion']['idEstructura'][ $j])
                                            
                                            <li><a href="erp-aplicaciones.html">{{$_SESSION['menu']['contextual'][$nombreAplicacion]['opcion']['nombre'][$j]}}</a></li>
                                         
                                        @endif
                                    @endfor
                                </ul>
 
                            </li>
                        @endfor
                    
                    @endif
                
                </ul>
    
            </div>
        </nav>
    
        <div id="page-wrapper" class="gray-bg">
            <div class="row border-bottom">
                <nav class="navbar navbar-static-top white-bg" role="navigation" style="margin-bottom: 0">
                    <div class="navbar-header">
                        <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i> </a>
                    </div>
                    <ul class="nav navbar-top-links navbar-right">
                        <li>
                            <span class="m-r-sm text-muted welcome-message"><i class="fa fa-cloud"></i>{{$nombreAplicacion}} | {{$nombreEmpresa}}</span>
                        </li>
                        <li class="dropdown">
                                <a class="dropdown-toggle count-info" data-toggle="dropdown" href="#" aria-expanded="false">
                                    <i class="fa fa-th"></i>
                                </a>
                            <div class="dropdown-menu dropdown-apps float-e-margins">
                                @if (isset($_SESSION['menu']['aplicaciones']['id']))

                                    @for ($i = 0; $i < count($_SESSION['menu']['aplicaciones']['id']); $i++)
                                        <button type="button" class="btn btn-link">
                                            <i class="{{$_SESSION['menu']['aplicaciones']['icono'][$i]}}"></i>
                                            <h3>{{$_SESSION['menu']['aplicaciones']['nombre'][$i]}}</h3>
                                        </button>
                                    @endfor

                                @endif
                            </div>
                        </li>
                        @if (isset($_SESSION['menu']['principal']['id']))

                            @for ($i = 0; $i < count($_SESSION['menu']['principal']['id']); $i++)
                                <li class="">
                                    <a class="dropdown-toggle count-info" data-toggle="dropdown" href="#" aria-expanded="false">
                                        <i class="{{$_SESSION['menu']['principal']['icono'][$i]}}"></i>  <span class="label label-info"></span>
                                    </a>
                                </li>
                            @endfor

                        @endif
                        <li class="">
                                <a class="dropdown-toggle count-info" data-toggle="dropdown" href="#" aria-expanded="false">
                                    <i class="fa fa-envelope"></i>  <span class="label label-info"></span>
                                </a>
                        </li>
                        <li class="">
                            <a class="dropdown-toggle count-info" data-toggle="dropdown" href="#" aria-expanded="false">
                                <i class="fa fa-bell"></i>  <span class="label label-info"></span>
                            </a>
                        </li>
                        <li class="">
                            <a class="dropdown-toggle count-info" data-toggle="dropdown" href="#" aria-expanded="false">
                                <i class="fa fa-life-ring"></i>
                            </a>
                        </li>
                        <li>
    
                            <a href="{{ route('logout') }}"
                            onclick="event.preventDefault();
                                          document.getElementById('logout-form').submit();">
                             <i class="fa fa-sign-out-alt"></i>  {{ __('auth.Logout') }}
                            </a>
    
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                            </form>
                        </li>
                    </ul>
    
                </nav>
            </div>
            <div class="wrapper wrapper-content animated fadeInRight">

                @yield('content')
            </div>
            <div class="footer">
                <div class="pull-right">
                    <strong>Copyright</strong> Innove, S.A. &copy; 2019
                </div>
            </div>
    
        </div>
    </div>




    @include('temes.inspinia.includes.js')
</body>
</html>
