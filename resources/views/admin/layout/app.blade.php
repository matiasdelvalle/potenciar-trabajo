<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- <link rel="shortcut icon" href="{{ asset('images/favicon.ico') }}"> -->
    <title>{{ env('APP_NAME') }}</title>
    <link href="{{ asset('/admin_style/assets/jquery-toggles/toggles-full.css') }}"             type="text/css" 	rel="stylesheet">
    <link href="{{ asset('/admin_style/assets/iconsmind/iconsmind.min.css') }}"                 type="text/css" 	rel="stylesheet">
    <link href="{{ asset('/admin_style/assets/font-awesome-6.1.0/css/all.min.css') }}"          type="text/css" 	rel="stylesheet">
    <link href="{{ asset('/admin_style/assets/ionicons-2.0.1/css/ionicons.css') }}"             type="text/css" 	rel="stylesheet">
    <link href="{{ asset('/admin_style/assets/perfect-scrollbar/src/perfect-scrollbar.css') }}" type="text/css" 	rel="stylesheet">
    <link href="{{ asset('/admin_style/assets/animate/animate.css') }}"                         type="text/css" 	rel="stylesheet">
    <link href="{{ asset('/admin_style/assets/toastr/toastr.min.css') }}" 						type="text/css" 	rel="stylesheet">
    <link href='{{ asset("admin_style/assets/sweetalert2/sweetalert2.min.css") }}' 				type="text/css"     rel="stylesheet">
    <link href="{{ asset('/admin_style/assets/select2/select2.css') }}" 						type="text/css" 	rel="stylesheet">
    <link href="{{ asset('/admin_style/css/quirk.css') }}"                                      type="text/css" 	rel="stylesheet">
    
    @yield('css')
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  	<!--[if lt IE 9]>
  		<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
  		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  	<![endif]-->
    </head>
    <body>
        <header>
            <div class="headerpanel" style="z-index:99">
                <div class="logopanel" style="text-align: center;">
                    <a href="{{ url('/') }}">
                        <img src="{{ asset('images/logo-desarrollo-social.svg') }}" alt="" class="img-responsive" style="width:50%;margin:auto;padding-top: 10px;">
                    </a>
                </div><!-- logopanel -->
                <div class="headerbar">
                    <a id="menuToggle" class="menutoggle">
                        <i class="fa fa-bars"></i>
                    </a>
                    <div class="header-right" style="position: absolute;right: 0px;">
                            <ul class="headermenu">
                                <li>
                                    <div class = "notification hide">
                                    <div class = "notBtn" href = "#">
                                        
                                        <div class = "number">2</div> <!-- NUMERO DE NOTIFICACIONES -->
                                        <i class="fas fa-bell"></i>
                                        <div class = "box">
                                            <div class = "display">
                                            <div class = "cont">
                                                <div class = "sec new">
                                                <a href = "#"><!-- LINK AL QUE LLEVA LA NOTIFICACIÓN -->
                                                <div class = "txt">Texto de la notificación</div>
                                                <div class = "txt sub">11/7 - 2:30 pm</div>
                                                </a>
                                                </div>
                                                
                                            </div>
                                            </div>
                                        </div>
                                    </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-logged" data-toggle="dropdown">
                                            <img src="{{ asset('images/default.jpg') }}" alt="" style="width: 35px; padding: 2px; border:2px solid #c6c6c6" />
                                        </button>
                                        <div class="dropdown-menu pull-right">
                                            <div class="media leftpanel-profile" style="max-width: 100%;width:300px">
                                                <div class="media-body" style="width: 25%">
                                                    <a href="javascript:void(0)">
                                                        <img src="{{  asset('images/default.jpg') }}" alt="" class="media-object img-circle"/>
                                                    </a>
                                                </div>
                                                <div class="media-body">
                                                    <span>{{ Auth::user()->name }} {{ Auth::user()->apellido }}</span>
                                                    <br>
                                                    <span>{{ Auth::user()->email }}</span>
                                                </div>
                                                <div class="row" style="border-top: 1px solid #636a6b;margin-top: 10px;">
                                                    <div class="col-md-12" style="margin-top: 10px;"> 
                                                        <div class="col-md-10">
                                                            <a href="{{ url('/cambiarpass') }}">Cambiar Contraseña</a><br>
                                                            <a href="{{ url('/logout') }}">Cerrar Sesión</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
        </header>
        <div class="leftpanel" style="overflow:hidden;">
            @include('admin.layout.menu')
        </div>
        <div class="mainpanel">
            <div class="contentpanel" style="opacity: 0;position:fixed;top:30px;margin-bottom:50px;">
                @yield('content')
            </div>
        </div>
    </div>
</div>

<script src="{{asset('/admin_style/assets/jquery/jquery-2.2.3.min.js')}}"></script>
<script src="{{asset('/admin_style/assets/bootstrap/bootstrap.min.js')}}"></script>
<script src="{{asset('/admin_style/assets/jquery-toggles/toggles.js')}}"></script>
<script src="{{asset('/admin_style/assets/perfect-scrollbar/src/jquery.mousewheel.js')}}"></script>
<script src="{{asset('/admin_style/assets/perfect-scrollbar/src/perfect-scrollbar.js')}}"></script>
<script src="{{asset('/admin_style/assets/pace/pace.min.js')}}"></script>
<script src="{{asset('/admin_style/js/dashboard.js')}}"></script>
<!-- <script src="{{asset('js/app.js') }}"></script> -->
@yield('js')
</body>
</html>
