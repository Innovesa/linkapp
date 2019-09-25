<!DOCTYPE html>
<html>

    <head>
		<meta charset="utf-8">
    	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	    
	    <title>LinkApp | @yield('title', 'ERP') </title>

	    @include('temes.inspinia.includes.css')
 
	</head>
    <body class="verify">

		
		<div id="page-wrapper" class="gray-bg">
	        <div class="row border-bottom">

                    <nav class="navbar navbar-static-top  " role="navigation" style="margin-bottom: 0">
                            <div class="navbar-header">
                                    <img src="{{ asset('img/innove/logo.png') }}" class="verifyLogo" alt="logo"> 
                           </div>

                            <ul class="nav navbar-top-links navbar-right">
                                @guest
                                    <li>
                                        <a href="{{ route('login') }}">
                                            <i class="fa fa-sign-out"></i>  {{ __('auth.Login') }}
                                        </a>
                                    </li>
                                @else
                                    <li>
                                        <span class="m-r-sm text-muted welcome-message">{{\Auth::User()->persona->nombre}}</span>
                                    </li>
                                    <li class="dropdown">
                                        <a class="dropdown-toggle count-info" data-toggle="dropdown" href="#">
                                            <i class="fa fa-envelope"></i>  <span class="label label-warning">0</span>
                                        </a>
                                        <ul class="dropdown-menu dropdown-messages">
                    
                                        </ul>
                                    </li>
                                    <li class="dropdown">
                                        <a class="dropdown-toggle count-info" data-toggle="dropdown" href="#">
                                            <i class="fa fa-bell"></i>  <span class="label label-primary">0</span>
                                        </a>
                                        <ul class="dropdown-menu dropdown-alerts">
                    
                                        </ul>
                                    </li>
                                    <li>
                    
                                        <a href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                          document.getElementById('logout-form').submit();">
                                           <i class="fa fa-sign-out"></i>  {{ __('auth.Logout') }}
                                         </a>
                    
                                         <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                                @csrf
                                         </form>
                                    </li>
                                @endguest
                            </ul>
                            
                    
                    </nav>
			</div>

			

			<div class="wrapper wrapper-content">
                    @yield('content')
            </div>
            
		</div>

		@include('temes.inspinia.includes.js')
    </body>
</html>
