<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>LinkApp | @if(session('aplicacion') !== null){{session('aplicacion')->nombre}} @endif </title>

    @include('temes.inspinia.includes.css')

</head>

<body>

    <div id="wrapper">

        <nav class="navbar-default navbar-static-side" role="navigation">
            <div class="slimScrollDiv">
                <ul class="nav metismenu" id="side-menu">
                    <li class="nav-header">
                        <div class="dropdown profile-element">
                                <img alt="image" class="img-circle" src="{{ route('persona.image',['filename' => \Auth::User()->persona->img ]) }}">
                                <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                                <span class="clear"> <span class="block m-t-xs"> <strong class="font-bold">{{\Auth::User()->persona->nombre}}</strong>
                                 </span> <span class="text-muted text-xs block">Perfil <b class="caret"></b></span> </span> </a>
                                <ul class="dropdown-menu animated fadeInRight m-t-xs">

                                    @if (session('estructura') !== null)
                                        @for ($i = 0; $i < count(session('estructura')); $i++)
                                            @if (session('estructura')[$i]['idCompania'] == session('compania')['id'])
            
                                                 @if (isset(session('estructura')[$i]['menus']['MENU_PERFIL']))
                                                    @for ($j = 0; $j < count(session('estructura')[$i]['menus']['MENU_PERFIL']); $j++)
                                                        
                                                            @for ($h = 0; $h < count(session('estructura')[$i]['menus']['MENU_PERFIL'][$j]['opciones']); $h++)

                                                                @for ($g = 0; $g < count(session('estructura')[$i]['menus']['MENU_PERFIL'][$j]['opciones'][$h]['opciones']); $g++)
                                                                    <li><a href="#">{{session('estructura')[$i]['menus']['MENU_PERFIL'][$j]['opciones'][$h]['opciones'][$g]['nombre']}}</a></li>
                                                                @endfor
                                                                
                                                            @endfor
                    
                                                    @endfor
                                                    <li class="divider"></li>
                                                 @endif
            
                                            @endif
                                        @endfor
                                    @endif

                                        <li>
                                            <a href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                        document.getElementById('logout-form').submit();">
                                                <i class="fa fa-sign-out-alt"></i>  {{ __('auth.Logout') }}
                                            </a>
                    
                                        </li>

                                    </ul>
                        </div>
                        <div class="logo-element">
                                LA
                        </div>
                    </li>
                        <!-- menu contextual--> 
                        @if (session('estructura') !== null)
                            @for ($i = 0; $i < count(session('estructura')); $i++)
                                @if (session('estructura')[$i]['idCompania'] == session('compania')['id'])

                                     @if (isset(session('estructura')[$i]['menus']['MENU_CONTEXTUAL']))
                                        @for ($j = 0; $j < count(session('estructura')[$i]['menus']['MENU_CONTEXTUAL']); $j++)
        
                                            @if (session('estructura')[$i]['menus']['MENU_CONTEXTUAL'][$j]['id'] == session('aplicacion')->id )
                                                @for ($h = 0; $h < count(session('estructura')[$i]['menus']['MENU_CONTEXTUAL'][$j]['opciones']); $h++)
                                                    <li>
                                                        <a href="#"><i class="{{session('estructura')[$i]['menus']['MENU_CONTEXTUAL'][$j]['opciones'][$h]['icono']}}"></i>
                                                             <span class="nav-label">{{session('estructura')[$i]['menus']['MENU_CONTEXTUAL'][$j]['opciones'][$h]['nombre']}}</span>
                                                        </a>
                                                        <ul class="nav nav-second-level collapse" aria-expanded="true">

                                                            @for ($g = 0; $g < count(session('estructura')[$i]['menus']['MENU_CONTEXTUAL'][$j]['opciones'][$h]['opciones']); $g++)
                                                                <li>
                                                                    <a href="{{url('/').session('estructura')[$i]['menus']['MENU_CONTEXTUAL'][$j]['opciones'][$h]['opciones'][$g]['accion']}}">
                                                                        {{session('estructura')[$i]['menus']['MENU_CONTEXTUAL'][$j]['opciones'][$h]['opciones'][$g]['nombre']}}
                                                                    </a>
                                                                </li>
                                                            @endfor

                                                        </ul>
                                                    </li>
                                                @endfor
                                            @endif
                                        @endfor
                                     @endif

                                @endif
                            @endfor
                        @endif
                <!-- end menu contextual-->     
 
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
                            <span class="m-r-sm text-muted welcome-message"><i class="fa fa-cloud"></i>  @if(session('aplicacion') !== null){{session('aplicacion')->nombre}} @endif  |  @if(session('compania') !== null){{session('compania')->nombre}} @endif</span>
                        </li>
                    <li class="dropdown">
                        <a class="dropdown-toggle count-info" data-toggle="dropdown" href="#" aria-expanded="false">
                            <i class="fa fa-th"></i>
                        </a>
                        <div class="dropdown-menu dropdown-apps float-e-margins">

                            <!-- menu de aplicaciones -->
                            @if (session('estructura') !== null)
                                @for ($i = 0; $i < count(session('estructura')); $i++)
                                    @if (session('estructura')[$i]['idCompania'] == session('compania')['id'])

                                        @if (isset(session('estructura')[$i]['menus']['MENU_APLICACIONES']))
                                            @for ($j = 0; $j < count(session('estructura')[$i]['menus']['MENU_APLICACIONES']); $j++)
                                                <button type="button" class="@if(session('estructura')[$i]['menus']['MENU_APLICACIONES'][$j]['id'] == session('aplicacion')->id)btn btn-primary @else btn btn-link @endif "

                                                 onClick="location.href='{{url('/').session('estructura')[$i]['menus']['MENU_APLICACIONES'][$j]['accion'].session('estructura')[$i]['menus']['MENU_APLICACIONES'][$j]['id']}}';">

                                                <i class="{{session('estructura')[$i]['menus']['MENU_APLICACIONES'][$j]['icono']}}"></i>
                                                <h3>{{session('estructura')[$i]['menus']['MENU_APLICACIONES'][$j]['nombre']}}</h3>

                                                </button>
                                            @endfor
                                        @endif

                                    @endif
                                @endfor
                            @endif
                            <!-- end  menu de aplicaciones -->
                        </div>
                    </li>

                    <!-- menu pricipal--> 
                 @if (session('estructura') !== null)
                    @for ($i = 0; $i < count(session('estructura')); $i++)
                        @if (session('estructura')[$i]['idCompania'] == session('compania')['id'])

                             @if (isset(session('estructura')[$i]['menus']['MENU_PRINCIPAL']))
                                @for ($j = 0; $j < count(session('estructura')[$i]['menus']['MENU_PRINCIPAL']); $j++)
                                   
                                        @for ($h = 0; $h < count(session('estructura')[$i]['menus']['MENU_PRINCIPAL'][$j]['opciones']); $h++)

                                                @for ($g = 0; $g < count(session('estructura')[$i]['menus']['MENU_PRINCIPAL'][$j]['opciones'][$h]['opciones']); $g++)
                                                    <li class="">
                                                        <a class="dropdown-toggle count-info" data-toggle="dropdown" href="#" aria-expanded="false">
                                                            <i class="{{session('estructura')[$i]['menus']['MENU_PRINCIPAL'][$j]['opciones'][$h]['opciones'][$g]['icono']}}"></i>
                                                        </a>
                                                    </li>
                                                @endfor

                                            </li>
                                        @endfor
                                   
                                @endfor
                             @endif

                        @endif
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
                <!--end menu pricipal--> 
                    </ul>
        
                    </nav>
            </div>


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
