@extends('layouts.main')

@section('title','Edit Profile')

@section('content')
    
  <div class="container">
    <div class="card mx-auto" style="max-width: 600px;">
      <div class="card-body">
        <h4 class="card-title mb-4">Edit Profile Page</h4>

        <form method="POST" action="{{ route('profile.update') }}"  enctype="multipart/form-data">
          @csrf
          @method('PUT')
          <div class="mb-3 row">
            <label for="name" class="col-sm-3 col-form-label">Name</label>
            <div class="col-sm-9">
              <input type="text" name="user_name" class="form-control" id="name" value="{{$user->user_name}}">
            </div>
          </div>

          <div class="mb-3 row">
            <label for="email" class="col-sm-3 col-form-label">User Email</label>
            <div class="col-sm-9">
              <input type="email" name="email" class="form-control" id="email" value="{{$user->email}}">
            </div>
          </div>

          <div class="mb-3 row">
            <label for="profileImage" class="col-sm-3 col-form-label">Profile Image</label>
            <div class="col-sm-9">
              <input type="file" name="user_image" class="form-control" id="profileImage">
            </div>
          </div>

          <div class="text-end">
            <input value="Update Profile" type="submit" class="btn btn-primary">
          </div>

        </form>
      </div>
    </div>




        <form method="POST" action="{{ route('profile.changepass') }}">
    @csrf
    @method('PUT')
    <div class="card mx-auto mt-4" style="max-width: 600px;">
      <div class="card-body">
        <h4 class="card-title mb-4">Change Password</h4>

          <div class="mb-3 row">
            <label for="name" class="col-sm-3 col-form-label">Old Password</label>
            <div class="col-sm-9">
              <input type="password" name="OldPassword" class="form-control"  placeholder="Old Password">
            </div>
          </div>

          <div class="mb-3 row">
            <label for="name" class="col-sm-3 col-form-label">New Password</label>
            <div class="col-sm-9">
              <input type="password" name="NewPassword" class="form-control"  placeholder="New Password">
            </div>
          </div>

          <div class="text-end">
            <input value="Change Password" type="submit" class="btn btn-primary">
          </div>

        </form>
      </div>
    </div>
  </div>
@endsection


@section('script')
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
        @if(session('success'))
        toastr.options = {
            "closeButton": true,
            "progressBar": true,
            "timeOut": "2000",
            "extendedTimeOut": "3000"
        }
        toastr.success("{{ session('success') }}");
    @endif
</script>
@endsection