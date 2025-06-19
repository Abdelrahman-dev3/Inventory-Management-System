<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Login Page</title>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet"/>
  <link rel="stylesheet" href="{{ asset('css/login.css') }}">
</head>
<body style="background: url('http://127.0.0.1:8000/images/bg_sign.jpg') no-repeat center center/cover;backdrop-filter: blur(10px); background-color: rgba(255,255,255,0.3); border: none; height: 100vh; display: flex; justify-content: center; align-items: center;">

  <div class="Login-box">
    <img src="images/logo.png" class="logo">
    <h2>Login In</h2>
    <form action="{{ route('regester') }}" method="POST">
      @csrf
      <input type="text" name="username" placeholder="Username" >
      <input type="password" name="password" placeholder="Password" >
      <input style="background: #007b8e; color:white" type="submit" value="Login In">
    </form>
    <div class="links">
      <a href="#">Forgot your password ?</a>
      <a href="{{ route('signup') }}">Create an account</a>
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
