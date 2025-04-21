<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title> AHT | Login</title>
    <link rel="icon" href="{{ asset('assets/img/favicon.svg') }}" type="image/svg+xml" />

    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/font-awesome/css/font-awesome.css') }}" rel="stylesheet">

    <link href="{{ asset('assets/css/animate.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">

    <style>
        #custom-login .logo-name {
            font-size: 166px;
            font-weight: bold;
            display: inline-block;
            letter-spacing: 2px;
        }

        #custom-login .custom-container {
            width: 400px;
            padding: 30px;
        }

        @media (max-width: 480px) {
            #custom-login .logo-name {
                display: none;
            }

            body {
                display: flex;
                align-items: center;
                justify-content: center;
            }

            #custom-login .custom-container {
                width: 100%;
                padding: 15px;
            }
        }
    </style>
</head>

<body id="custom-login" class="gray-bg">
    <div class="middle-box text-center loginscreen animated fadeInDown custom-container">
        <div class="text-center">
            <h1 class="logo-name"> AHT </h1>
        </div>


        <h3>Welcome to AHT web app</h3>
        @if (session('error'))
            <div class="alert alert-danger alert-dismissable">
                <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                {{ session('error') }}
            </div>
        @endif
        @if (session('success'))
            <div class="alert alert-success alert-dismissable">
                <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                {{ session('success') }}
            </div>
        @endif

        <!-- <p>Login in. To see it in action.</p> -->
        <form class="m-t" role="form" method="POST" action="{{ route('postLogin') }}">
            @csrf
            <div class="form-group">
                <input name="email" type="email" class="form-control" placeholder="Email"
                    value="{{ old('email') }}" required="">
                @error('email')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <input name="password" value="{{ old('password') }}" type="password" class="form-control"
                    placeholder="Password" required>
                @error('password')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary block full-width m-b">Login</button>

            <a href="{{ route('password.request') }}"><small>Forgot password?</small></a>
        </form>

    </div>

    <!-- Mainly scripts -->
    <script src="{{ asset('assets/js/jquery-3.1.1.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>

</body>

</html>
