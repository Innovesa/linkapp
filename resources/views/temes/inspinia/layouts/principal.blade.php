@php
    $nombreAplicacion = null;

    if(isset($_SESSION['Estructura']['menus']['aplicaciones'])){

        for($i = 0; $i < count($_SESSION['Estructura']['menus']['aplicaciones']); $i++){

            if ($_SESSION['Estructura']['menus']['aplicaciones'][$i]['id'] == $_SESSION['aplicacion'] ) {
                $nombreAplicacion = $_SESSION['Estructura']['menus']['aplicaciones'][$i]['nombre'];
            }

        }

    }

@endphp

<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>LinkApp | {{ $nombreAplicacion}} </title>

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

                                    @if (isset($_SESSION['Estructura']['menus']['perfil']))

                                        @for ($p = 0; $p < count($_SESSION['Estructura']['menus']['perfil']); $p++)
                                            @for ($j = 0; $j < count($_SESSION['Estructura']['menus']['perfil'][$p]['items']); $j++)
                                                @for ($i = 0; $i < count($_SESSION['Estructura']['menus']['perfil'][$p]['items'][$j]['items']); $i++)
                                                    <li><a href="#">{{$_SESSION['Estructura']['menus']['perfil'][$p]['items'][$j]['items'][$i]['nombre']}}</a></li>
                                                @endfor
                                            @endfor
                                        @endfor

                                    @endif

                                    <li class="divider"></li>
                                    <li><a href="#">Salir</a></li>
                                </ul>
                        </div>
                        <div class="logo-element">
                            LA
                        </div>
                    </li>
                    
                    @if (isset($_SESSION['Estructura']['menus']['contextual']))

                        @for ($p = 0; $p < count($_SESSION['Estructura']['menus']['contextual']); $p++)
                            
                            @if($_SESSION['Estructura']['menus']['contextual'][$p]['id'] == $_SESSION['aplicacion'])
                                @for ($i = 0; $i < count($_SESSION['Estructura']['menus']['contextual'][$p]['items']); $i++)
                                    <li>
                                        <a href="{{$_SESSION['Estructura']['menus']['contextual'][$p]['items'][$i]['accion']}}"><i class="{{$_SESSION['Estructura']['menus']['contextual'][$p]['items'][$i]['icono']}}"></i> <span class="nav-label">{{$_SESSION['Estructura']['menus']['contextual'][$p]['items'][$i]['nombre']}}</span></a>
                                    
                                        <ul class="nav nav-second-level collapse" aria-expanded="true">
                                            @for ($j = 0; $j <  count($_SESSION['Estructura']['menus']['contextual'][$p]['items'][$i]['items']); $j++)

                                                <li><a href="{{$_SESSION['Estructura']['menus']['contextual'][$p]['items'][$i]['items'][$j]['accion']}}">{{$_SESSION['Estructura']['menus']['contextual'][$p]['items'][$i]['items'][$j]['nombre']}}</a></li>
                                            
                                            @endfor
                                        </ul>
        
                                    </li>
                                @endfor
                            @endif

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
                            <span class="m-r-sm text-muted welcome-message"><i class="fa fa-cloud"></i>{{$nombreAplicacion}} | Pruebas</span>
                        </li>
                        <li class="dropdown">
                                <a class="dropdown-toggle count-info" data-toggle="dropdown" href="#" aria-expanded="false">
                                    <i class="fa fa-th"></i>
                                </a>
                            <div class="dropdown-menu dropdown-apps float-e-margins">
                                @if (isset($_SESSION['Estructura']['menus']['aplicaciones']))

                                    @for ($i = 0; $i < count($_SESSION['Estructura']['menus']['aplicaciones']); $i++)
                                        <a href="{{url($_SESSION['Estructura']['menus']['aplicaciones'][$i]['accion'])}}" type="button" class="btn btn-link">
                                            <i class="{{$_SESSION['Estructura']['menus']['aplicaciones'][$i]['icono']}}"></i>
                                            <h3>{{$_SESSION['Estructura']['menus']['aplicaciones'][$i]['nombre']}}</h3>
                                        </a>
                                    @endfor

                                @endif
                            </div>
                        </li>
                        @if (isset($_SESSION['Estructura']['menus']['principal']))

                            @for ($p = 0; $p < count($_SESSION['Estructura']['menus']['principal']); $p++)
                                @for ($j = 0; $j < count($_SESSION['Estructura']['menus']['principal'][$p]['items']); $j++)
                                    @for ($i = 0; $i < count($_SESSION['Estructura']['menus']['principal'][$p]['items'][$j]['items']); $i++)
                                        <li class="">

                                            <a class="dropdown-toggle count-info" data-toggle="dropdown" href="#" aria-expanded="false">
                                                <i class="{{$_SESSION['Estructura']['menus']['principal'][$p]['items'][$j]['items'][$i]['icono']}}"></i> <span class="label label-info"></span>
                                            </a>

                                        </li>
                                    @endfor
                                @endfor
                            @endfor

                        @endif
                        @if (isset($_SESSION['Estructura']['menus']['principalPredeterminadas']))

                            @for ($p = 0; $p < count($_SESSION['Estructura']['menus']['principalPredeterminadas']); $p++)
                                @for ($j = 0; $j < count($_SESSION['Estructura']['menus']['principalPredeterminadas'][$p]['items']); $j++)
                                    @for ($i = 0; $i < count($_SESSION['Estructura']['menus']['principalPredeterminadas'][$p]['items'][$j]['items']); $i++)
                                        <li class="">

                                            <a class="dropdown-toggle count-info" data-toggle="dropdown" href="#" aria-expanded="false">
                                                 <i class="{{$_SESSION['Estructura']['menus']['principalPredeterminadas'][$p]['items'][$j]['items'][$i]['icono']}}"></i> <span class="label label-info"></span>
                                            </a>

                                        </li>
                                    @endfor
                                @endfor
                            @endfor

                        @endif
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
