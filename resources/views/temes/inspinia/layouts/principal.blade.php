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
                                <img alt="image" class="img-circle" src="{{ url('/').'/persona/image/'.Auth::User()->persona->img }}">
                                <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                                <span class="clear"> <span class="block m-t-xs"> <strong class="font-bold">{{\Auth::User()->persona->nombre}}</strong>
                                 </span> <span class="text-muted text-xs block">Perfil <b class="caret"></b></span> </span> </a>
                                <ul class="dropdown-menu animated fadeInRight m-t-xs">

                                    @if (session('estructura') !== null && session('compania') !== null && session('aplicacion') !== null)
                                            
            
                                        @if (isset(session('estructura')[session('compania')->id]['MENU_PERFIL']))
                                            @for ($j = 0; $j < count(session('estructura')[session('compania')->id]['MENU_PERFIL']); $j++)
                                                        
                                                @for ($h = 0; $h < count(session('estructura')[session('compania')->id]['MENU_PERFIL'][$j]['opciones']); $h++)

                                                    @for ($g = 0; $g < count(session('estructura')[session('compania')->id]['MENU_PERFIL'][$j]['opciones'][$h]['opciones']); $g++)
                                                        <li><a href="#">{{session('estructura')[session('compania')->id]['MENU_PERFIL'][$j]['opciones'][$h]['opciones'][$g]['nombre']}}</a></li>
                                                    @endfor
                                                                
                                                @endfor
                    
                                            @endfor
                                                    <li class="divider"></li>
                                        @endif
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
                        @if (session('estructura') !== null && session('compania') !== null && session('aplicacion') !== null)


                             @if (isset(session('estructura')[session('compania')->id]['MENU_CONTEXTUAL']))
                                @for ($j = 0; $j < count(session('estructura')[session('compania')->id]['MENU_CONTEXTUAL']); $j++)
        
                                    @if (session('estructura')[session('compania')->id]['MENU_CONTEXTUAL'][$j]['id'] == session('aplicacion')->id )
                                        @for ($h = 0; $h < count(session('estructura')[session('compania')->id]['MENU_CONTEXTUAL'][$j]['opciones']); $h++)
                                            <li>
                                                <a href="#"><i class="{{session('estructura')[session('compania')->id]['MENU_CONTEXTUAL'][$j]['opciones'][$h]['icono']}}"></i>
                                                    <span class="nav-label">{{session('estructura')[session('compania')->id]['MENU_CONTEXTUAL'][$j]['opciones'][$h]['nombre']}}</span>
                                                </a>
                                                <ul class="nav nav-second-level collapse" aria-expanded="true">

                                                    @for ($g = 0; $g < count(session('estructura')[session('compania')->id]['MENU_CONTEXTUAL'][$j]['opciones'][$h]['opciones']); $g++)
                                                        <li>
                                                            <a href="{{url('/').session('estructura')[session('compania')->id]['MENU_CONTEXTUAL'][$j]['opciones'][$h]['opciones'][$g]['accion']}}">
                                                                {{session('estructura')[session('compania')->id]['MENU_CONTEXTUAL'][$j]['opciones'][$h]['opciones'][$g]['nombre']}}
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

                        <div class="btn-group cambioCompanias">

                            @if (session('estructura') !== null && session('compania') !== null && session('aplicacion') !== null)
                                @if (isset(session('estructura')['MENU_COMPANIAS']))

                                    @for ($i = 0; $i < count(session('estructura')['MENU_COMPANIAS']); $i++)
                                        @if (session('estructura')['MENU_COMPANIAS'][$i]['id'] == session('compania')->id)

                                            <span data-toggle="dropdown" class="dropdown-toggle" aria-expanded="false">
                                                <img src="{{ url('/').'/persona/image/'.session('estructura')['MENU_COMPANIAS'][$i]['imagen'] }}" class="navbar-form-custom">
                                                <span class="caret carretCambioCompanias"></span>
                                            </span>

                                        @endif

                                        <ul class="dropdown-menu">
                                            @if (session('estructura')['MENU_COMPANIAS'][$i]['id'] != session('compania')->id)

                                                <li>
                                                    <div class="text-center block" onclick="window.location.href = '{{route('compania.cambiar',['idCompania'=>session('estructura')['MENU_COMPANIAS'][$i]['id']])}}'">
                                                        <img src="{{ url('/').'/persona/image/'.session('estructura')['MENU_COMPANIAS'][$i]['imagen'] }}" class="navbar-form-custom">
                                                       
                                                    </div>
                                                </li>

                                            @endif
                                        </ul>
                                    @endfor
                                @endif
                            @endif
                           
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
                            @if (session('estructura') !== null && session('compania') !== null && session('aplicacion') !== null)

                                        @if (isset(session('estructura')[session('compania')->id]['MENU_APLICACIONES']))
                                            @for ($j = 0; $j < count(session('estructura')[session('compania')->id]['MENU_APLICACIONES']); $j++)
                                                <button type="button" class="@if(session('estructura')[session('compania')->id]['MENU_APLICACIONES'][$j]['id'] == session('aplicacion')->id)btn btn-primary @else btn btn-link @endif "

                                                 onClick="location.href='{{url('/').session('estructura')[session('compania')->id]['MENU_APLICACIONES'][$j]['accion'].session('estructura')[session('compania')->id]['MENU_APLICACIONES'][$j]['id']}}';">

                                                <i class="{{session('estructura')[session('compania')->id]['MENU_APLICACIONES'][$j]['icono']}}"></i>
                                                <h3>{{session('estructura')[session('compania')->id]['MENU_APLICACIONES'][$j]['nombre']}}</h3>

                                                </button>
                                            @endfor
                                        @endif

                            @endif
                            <!-- end  menu de aplicaciones -->
                        </div>
                    </li>

                    <!-- menu pricipal--> 
                 @if (session('estructura') !== null && session('compania') !== null && session('aplicacion') !== null)

                             @if (isset(session('estructura')[session('compania')->id]['MENU_PRINCIPAL']))
                                @for ($j = 0; $j < count(session('estructura')[session('compania')->id]['MENU_PRINCIPAL']); $j++)
                                   
                                        @for ($h = 0; $h < count(session('estructura')[session('compania')->id]['MENU_PRINCIPAL'][$j]['opciones']); $h++)

                                                @for ($g = 0; $g < count(session('estructura')[session('compania')->id]['MENU_PRINCIPAL'][$j]['opciones'][$h]['opciones']); $g++)
                                                    <li class="">
                                                        <a class="dropdown-toggle count-info" data-toggle="dropdown" href="#" aria-expanded="false">
                                                            <i class="{{session('estructura')[session('compania')->id]['MENU_PRINCIPAL'][$j]['opciones'][$h]['opciones'][$g]['icono']}}"></i>
                                                        </a>
                                                    </li>
                                                @endfor

                                            </li>
                                        @endfor
                                   
                                @endfor
                             @endif

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

            
            <!-- Modal -->
            @if (session('estructura') !== null && session('compania') == null)

                <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header text-center">
                        <h2 class="modal-title" id="exampleModalLabel">Seleccione una compania</h2>
                        </div>
                            <div class="modal-body">
                                <form action="{{route('agregar.compania')}}" id="FormAddCompania" method="post">
                                    @csrf
                                    <div class="row align-items-center">
                                        @if (isset(session('estructura')['MENU_COMPANIAS']))

                                            @for ($i = 0; $i < count(session('estructura')['MENU_COMPANIAS']); $i++)
                                                <div class="col-sm-3">
                                                    <label class="btn btn-primary">
                                                        <img src="{{route('persona.image',['filename' =>session('estructura')['MENU_COMPANIAS'][$i]['imagen']])}}"  class="img-thumbnail img-check">
                                                        <input type="radio" name="compania" id="compania" value="{{session('estructura')['MENU_COMPANIAS'][$i]['id']}}" class="hidden" autocomplete="off">
                                                        <h5>{{session('estructura')['MENU_COMPANIAS'][$i]['nombre']}}</h5>
                                                    </label>
                                                </div>
                                            @endfor
                                            
                                        @endif

                                       
                                        

                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                 <button type="submit" id="btnFormAddCompania" class="btn btn-primary">Aceptar</button>
                            </div>
                    </div>
                    </div>
                </div>

                
            @endif
        

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
