@php  \TraerMenus::traerTodo();   @endphp

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
                    <img alt="image" class="img-circle" src="img/perfil.png">
                                <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                                <span class="clear"> <span class="block m-t-xs"> <strong class="font-bold">Oscar Acuña Williams</strong>
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
                    @isset($_SESSION['menusHijos'])
                        @for ($j = 0; $j < count($_SESSION['menusPadres']); $j++)
                            @if($_SESSION['menusPadres'][$j]['nombre'] == $nombreAplicacion)
                                @for ($i = 0; $i < count($_SESSION['menusHijos']); $i++)
                                    @if($_SESSION['menusPadres'][$j]['id'] == $_SESSION['menusHijos'][$i]['superior'])

                                        <li>

                                            <a href="#"><i class="{{$_SESSION['menusHijos'][$i]['icono']}}"></i> <span class="nav-label">{{$_SESSION['menusHijos'][$i]['nombre']}}</span></a>
                                        
                                            <ul class="nav nav-second-level collapse" aria-expanded="true">

                                                @for ($y = 0; $y < count($_SESSION['opciones']); $y++)
                                                    @if($_SESSION['opciones'][$y]['idEstructura'] == $_SESSION['menusHijos'][$i]['id'])
                                                         <li><a href="{{route('prueba')}}">{{$_SESSION['opciones'][$y]['nombre']}}</a></li>
                                                     @endif
                                                @endfor

                                            </ul>

                                        </li>
                                    @endif
                                @endfor
                            @endif
                        @endfor
                    @endisset
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
                                <button type="button" class="btn btn-primary" onClick="window.open('erp.html','self');">
                                <i class="fa fa-cloud"></i>
                                <h3>ERP</h3>
                                </button>
                                <button type="button" class="btn btn-link">
                                <i class="fa fa-users"></i>
                                <h3>CRM</h3>
                                </button>
                                <button type="button" class="btn btn-link">
                                <i class="fa fa-truck-moving"></i>
                                <h3>SRM</h3>
                                </button>
                                <button type="button" class="btn btn-link">
                                <i class="fa fa-box"></i>
                                <h3>WMS</h3>
                                </button>
                                <button type="button" class="btn btn-link">
                                <i class="fa fa-box-open"></i>
                                <h3>MRP</h3>
                                </button>
                                <button type="button" class="btn btn-link">
                                <i class="fa fa-money-bill-alt"></i>
                                <h3>FRM</h3>
                                </button>
                                <button type="button" class="btn btn-link">
                                <i class="fa fa-tasks"></i>
                                <h3>PRY</h3>
                                </button>
                                <button type="button" class="btn btn-link">
                                <i class="fa fa-database"></i>
                                <h3>BI</h3>
                                </button>
                                <button type="button" class="btn btn-link">
                                <i class="fa fa-globe"></i>
                                <h3>API</h3>
                                </button>
                            </div>
                        </li>
    
                        <li class="">
                                <a class="dropdown-toggle count-info" data-toggle="dropdown" href="#" aria-expanded="false">
                                    <i class="fa fa-envelope"></i>  <span class="label label-info">16</span>
                                </a>
                                </li>
                        <li class="">
                            <a class="dropdown-toggle count-info" data-toggle="dropdown" href="#" aria-expanded="false">
                                <i class="fa fa-bell"></i>  <span class="label label-info">8</span>
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
