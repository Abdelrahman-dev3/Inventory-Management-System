<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Sign Up Page</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet"/>
    <link rel="stylesheet" href="{{ asset('css/signup.css') }}">
    
</head>
<body style="background: url('{{ asset('images/bg_sign.jpg') }}') no-repeat center center/cover;backdrop-filter: blur(10px); background-color: rgba(255,255,255,0.3); border: none; height: 100vh; display: flex; justify-content: center; align-items: center;">

    <div class="signup-box">
        <img src="{{ asset('images/logo.png') }}" class="logo" />
        <h2>Create Account</h2>
        <form method="POST" action="{{ route('signup.store') }}">
            @csrf
            <input type="text"name="username" value="{{old('username')}}" placeholder="Username" >
            <input type="email"name="email" value="{{old('email')}}" placeholder="Email" >
            <input type="password"name="password" placeholder="Password" >
            <input type="password" name="password_confirmation"  placeholder="Password Confirmation">
            <input style="background: #007b8e;color:white;cursor: pointer;" type="submit" value="Sign Up">
        </form>
        <div class="links">
            <a href="{{ route('login') }}">Already have an account? Log in</a>
        </div>
    </div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<script>
    @if ($errors->any())
        toastr.options = {
            "closeButton": true,
            "progressBar": true,
            "timeOut": "7000",
            "extendedTimeOut": "3000"   
        };

        @foreach ($errors->all() as $error)
            toastr.error("{{ $error }}");
        @endforeach
    @endif
</script>
</body>
</html>
