<!DOCTYPE html>
<html>

    <head>
		<meta charset="utf-8">
    	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	    
	    <title>LinkApp | @yield('title', 'ERP') </title>

	    @include('temes.inspinia.css')
 
	</head>
    <body class="pace-done fixed-sidebar">

	    <div id="wrapper">
			@include('temes.inspinia.navigation')
		</div>
		
		<div id="page-wrapper" class="gray-bg">
	        <div class="row border-bottom">
				<!-- Navigation -->
				@include('temes.inspinia.topnavbar')
			</div>

			
			<div class="row wrapper border-bottom white-bg page-heading">
			    <div class="col-sm-4">
			        <h2>@yield('titlePage', 'Titulo de la página') </h2>
			        <ol class="breadcrumb">
			            <li class="breadcrumb-item">
			                <a href="index.html">Inicio</a>
			            </li>
			            <li class="breadcrumb-item active">
			                <strong>Breadcrumb</strong>
			            </li>
			        </ol>
			    </div>
			    <div class="col-sm-8">
			        <div class="title-action">
			            <a href="" class="btn btn-primary">This is action area</a>
			        </div>
			    </div>
			</div>

			<div class="wrapper wrapper-content">
			    <div class="middle-box text-center animated fadeInRightBig">
			        <h3 class="font-bold">This is page content</h3>
			        <div class="error-desc">
			            You can create here any grid layout you want. And any variation layout you imagine:) Check out
			            main dashboard and other site. It use many different layout.
			            <br/><a href="index.html" class="btn btn-primary m-t">Dashboard</a>
			        </div>
			    </div>
			</div>


			<!-- Footer -->
	    	@include('temes.inspinia.footer')
		</div>

		@include('temes.inspinia.js')
    </body>
</html>