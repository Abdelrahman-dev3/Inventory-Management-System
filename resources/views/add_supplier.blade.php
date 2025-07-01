@extends('layouts.main')

@section('title', 'Add Supplier')

@section('content')
  <div class="container my-5">
    <div class="card shadow p-4">
      <h4 class="mb-4">Add Supplier Page</h4>
      <form method="POST" action="{{ route('supplier.store') }}">
        @csrf
        <div class="mb-3 row">
          <label for="supplierName" class="col-sm-2 col-form-label">Supplier Name</label>
          <div class="col-sm-10">
            <input type="text" name="supplier_name" value="{{old('supplier_name')}}" class="form-control" id="supplierName" placeholder="Enter supplier name">
          </div>
        </div>
        <div class="mb-3 row">
          <label for="supplierMobile" class="col-sm-2 col-form-label">Supplier Mobile</label>
          <div class="col-sm-10">
            <input name="supplier_mobile" value="{{old('supplier_mobile')}}" type="text" class="form-control" id="supplierMobile" placeholder="Enter mobile number">
          </div>
        </div>
        <div class="mb-3 row">
          <label for="supplierEmail" class="col-sm-2 col-form-label">Supplier Email</label>
          <div class="col-sm-10">
            <input type="email" name="supplier_email" value="{{old('supplier_email')}}" class="form-control" id="supplierEmail" placeholder="Enter email address">
          </div>
        </div>
        <div class="mb-3 row">
          <label for="supplierAddress" class="col-sm-2 col-form-label">Supplier Address</label>
          <div class="col-sm-10">
            <input type="text" name="supplier_address" value="{{old('supplier_address')}}" class="form-control" id="supplierAddress" placeholder="Enter address">
          </div>
        </div>
        <div class="text-start">
          <input type="submit" value="Add Supplier" class="btn btn-info text-white">
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