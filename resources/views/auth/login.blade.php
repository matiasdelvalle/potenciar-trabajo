<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Encode+Sans:wght@500&display=swap" rel="stylesheet">
    <style>
        .full-height {
            height: 80vh;
        }
        body{
            background-color: #f4f4f4;
        }
        .blue-fondo{
            position: absolute;
            width: 100%;
            height: 50vh;
            left: 0px;
            top: 0px;

            /* Secondary/50 */
            background: #37BBED;
        }
        h3{
            font-weight: bold;
            color: #333;
        }
    
        .gray{
            background-color: #F3F6F9;
        }
        .form-control{
            background-color: #F3F6F9;
            border: none;

        }
        .panel{
            background-color: white;
            border-radius: 10px;
        }
        .panel-body.text-center{
            padding: 40px;
        }
        .mb-20{
            margin-bottom: 20px;
        }
        h6{
            color: #0072BB;
        }
    </style>
</head>
<body>

    <div id="app full-height">
        <div class="blue-fondo"></div>
        <div class="container-fluid full-height">
            <div class="row align-items-center full-height">
                <div class="col"></div>
                <div class="col-md-4">
                <div class="panel-heading p-4 text-center mb-20">
                    <a href="{{ url('home') }}" style="text-decoration: none;color:inherit">
                        <img src="{{ asset('images/logo-desarrollo-social.svg') }}" alt="" style="width: 100%;max-width: 350px;">
                    </a>
                </div>
                <div class="panel panel-default">
                    <div class="panel-body text-center">

                        @if (count($errors) > 0)
                        <div class="alert alert-danger">
                            <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                            </ul>
                        </div>
                        @endif

                        <h3>Dirección de Registros Jurisdiccionales</h3>
                        <p>Desarrollo Social</p>
                        <form class="form-horizontal" method="POST" action="{{ route('login') }}" style="text-align:left;">
                                
                            {{ csrf_field() }}
                            
                            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                <div class="col-md-12">
                                    <label for="email">Usuario</label>
                                    <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>
                                    @if ($errors->has('email'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                <div class="col-md-12">
                                    <label for="password">Contraseña</label>
                                    <input id="password" type="password" class="form-control" name="password" required>
                                    @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <br>
                            
                            <div class="form-group">
                                <div class="col text-center">
                                    <button type="submit" class="btn btn-xl btn-block btn-primary">Iniciar Sesión</button>
                                </div>
                            </div>
                            
                            <div style="padding-left: 15px;" class="form-group">
                                <a href="{{ route('password.request') }}" class="text-center"><h6>¿Olvidaste tu contraseña? </h6></a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col"></div>
        </div>
    </div>
</div>
<script src="{{ asset('js/app.js') }}"></script>
</body>
</html>

