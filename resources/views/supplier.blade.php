@extends('layouts.main')

@section('title','supplier')

@section('content')
      <div class="container my-5">
    <div class="d-flex justify-content-between align-items-center mb-3">
    </div>

    <div class="row mb-3">
      <div class="col-md-6">
      <a href="{{ route('add_supplier') }}" class="btn btn-dark"><i class="bi bi-plus-circle"></i> Add Supplier</a>

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
          <th style="text-align: center;">Id</th>
          <th style="text-align: center;">Name</th>
          <th style="text-align: center;">Mobile Number</th>
          <th style="text-align: center;">Email</th>
          <th style="text-align: center;">Address</th>
          <th style="text-align: center;">Action</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($suppliers as $supplier)
        <tr>
          <td style="text-align: center;">{{ $supplier->id }}</td>
          <td style="text-align: center;">{{ $supplier->supplier_name  }}</td>
          <td style="text-align: center;">{{ $supplier->supplier_mobile }}</td>
          <td style="text-align: center;">{{ $supplier->supplier_email  }}</td>
          <td style="text-align: center;">{{ $supplier->supplier_address }}</td>
          <td style="text-align: center;display: flex;justify-content: space-evenly;">
            
            <form action="{{route('supplier.destroy', $supplier->id )}}" method="post">
              @method('DELETE')
              @csrf
              <button style="display: inline;" type="submit" class="btn btn-danger btn-sm">delete</button>
            </form>
            <a class="btn btn-success btn-sm" href="{{ route('supplier.edit',$supplier->id) }}">edit</a>
            
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