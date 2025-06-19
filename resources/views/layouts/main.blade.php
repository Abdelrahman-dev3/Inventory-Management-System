<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>@yield('title')</title>
  <link rel="icon" type="image/x-icon" href="{{ asset('images/logo.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet"/>
  @yield('script_link')
  <link rel="stylesheet" href="{{ asset('css/main.css') }}">
</head>
<body>
  @yield('style')
  <div class="topbar">
    <img src="{{ asset('images/logo.png') }}" class="logo">
    <div class="search">
      <input type="text" placeholder="Search...">
    </div>
    <a href="{{ route('profile') }}" class="user text-white text-decoration-none">
      <img src="{{ asset('uploads/users/' . Auth::user()->user_image) }}" alt="User">
      <span>{{ Auth::user()->user_name }} <i class="fa-solid fa-angle-down"></i></span>
    </div>
  </a>

  <div class="content-wrapper">
    <div class="sidebar">
      <h2>menu</h2>
      <ul>
        <a href="{{ route('dashboard') }}"><li><i class="fa-solid fa-home"></i> Dashboard</li></a>
        <a href="{{ route('supplier') }}"><li><i class="fa-solid fa-building"></i> Manage Suppliers</li></a>
        <a href="{{ route('customer') }}"><li><i class="fa-solid fa-shield-alt"></i> Manage Customers</li></a>
        <a href="{{ route('unit') }}"><li><i class="fa-solid fa-box"></i> Manage Units</li></a>
        <a href="{{ route('category') }}"><li><i class="fa-solid fa-layer-group"></i> Manage Category</li></a>
        <a href="{{ route('product') }}"><li><i class="fa-solid fa-bag-shopping"></i> Manage Product</li></a>
        <a href="{{ route('purchase') }}"><li><i class="fa-solid fa-file-invoice-dollar"></i> Manage Purchase</li></a>
        <a href="{{ route('inovice') }}"><li><i class="fa-solid fa-file-invoice"></i> Manage Invoice</li></a>
        <a href="{{ route('report') }}"><li><i class="fa-solid fa-boxes-stacked"></i> Manage Stock</li></a>
        <a href="#"><li><i class="fa-solid fa-headset"></i> Support</li></a>
      </ul>
    </div>

    <div class="main">
      @yield('content')
    </div>
  </div>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
      @yield('script')
</body>
</html>