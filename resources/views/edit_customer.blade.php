@extends('layouts.main')
@section('title', 'Update Customer')

@section('content')
  <div class="container my-5">
    <div class="card shadow p-4">
      <h4 class="mb-4">Update Customer Page</h4>
      <form method="POST" action="{{route('customer.update')}}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="mb-3 row">
          <label for="unitName" class="col-sm-2 col-form-label">Customer Name</label>
          <div class="col-sm-10">
            <input name="customer_name" value="{{$customer->customer_name}}" type="text" class="form-control" id="unitName" placeholder="Enter unit name">
            <input name="id" value="{{$customer->id}}" type="hidden" >
          </div>
        </div>
        <div class="mb-3 row">
          <label for="unitMobile" class="col-sm-2 col-form-label">Customer image</label>
          <div class="col-sm-10">
            <input  name="customer_image" value="{{$customer->customer_image}}" type="file" class="form-control" id="unitMobile" placeholder="Enter mobile number">
          </div>
        </div>
        <div class="mb-3 row">
          <label for="unitEmail" class="col-sm-2 col-form-label">Customer Email</label>
          <div class="col-sm-10">
            <input name="email" type="email" value="{{$customer->email}}" class="form-control" id="unitEmail" placeholder="Enter email address">
          </div>
        </div>
        <div class="mb-3 row">
          <label for="unitAddress" class="col-sm-2 col-form-label">Customer Address</label>
          <div class="col-sm-10">
            <input name="address" type="text" value="{{$customer->address}}" class="form-control" id="unitAddress" placeholder="Enter address">
          </div>
        </div>
        <div class="text-start">
          <input value="Update Customer" type="submit" class="btn btn-info text-white">
        </div>
      </form>
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
</script>
@endsection