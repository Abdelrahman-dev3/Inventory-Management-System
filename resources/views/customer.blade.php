@extends('layouts.main')

@section('title','Customer')

@section('content')
      <div class="container my-5">
    <div class="d-flex justify-content-between align-items-center mb-3">
    </div>

    <div class="row mb-3">
      <div class="col-md-6">
      <a href="{{ route('add_customer') }}" class="btn btn-dark"><i class="bi bi-plus-circle"></i> Add Customer</a>
      </div>
      <div class="col-md-6 text-end">
        <form method="GET" action="" class="mb-3">
          <input type="search" name="search" value="{{ $search ?? '' }}" placeholder="Search by name" class="form-control w-50 d-inline">
        </form>
      </div>
    </div>

    <table class="table table-bordered table-striped text-center align-middle">
      <thead class="table-light">
        <tr>
          <th>id</th>
          <th>Name</th>
          <th>Customer Image</th>
          <th>Email</th>
          <th>Address</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($customers as $customer)
          <tr>
            <td style="text-align: center;">{{ $customer->id }}</td>
            <td style="text-align: center;">{{ $customer->customer_name }}</td>
            <td style="text-align: center;"><img style="border-radius: 50%;" src="{{asset('uploads/customers/' . $customer->customer_image)}}"  width="60" alt="image"></td>
            <td >{{ $customer->email }}</td>
            <td>{{ $customer->address }}</td>
          <td style="text-align: center;display: flex;justify-content: space-evenly;">
            
            <a class="btn btn-info btn-sm" href="{{ route('customer.view',$customer->id) }}">view</a>
            
            <form action="{{route('customer.destroy', $customer->id )}}" method="post">
              @method('DELETE')
              @csrf
              <button style="display: inline;" type="submit" class="btn btn-danger btn-sm">delete</button>
            </form>

            <a class="btn btn-success btn-sm" href="{{ route('customer.edit',$customer->id) }}">edit</a>
            
          </td>
          </tr>
        @endforeach

      </tbody>
    </table>
  </div>

@endsection

@section('script')
<script>
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