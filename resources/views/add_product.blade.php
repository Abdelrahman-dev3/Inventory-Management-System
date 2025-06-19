@extends('layouts.main')

@section('title', 'Add product')

@section('content')
  <div class="container my-5">
    <div class="card shadow p-4">
      <h4 class="mb-4">Add product Page</h4>
      <form method="POST" action="{{route('product.store')}}">
        @csrf
        <div class="mb-3 row">
          <label for="productName" class="col-sm-2 col-form-label">product Name</label>
          <div class="col-sm-10">
            <input name="product_name" value="{{old('product_name')}}" type="text" class="form-control" id="productName" placeholder="Enter product name">
          </div>
        </div>

        <div class="mb-3">
          <label for="supplierSelect" class="form-label">Supplier Name</label>
          <select name="supplier" class="form-select" id="supplierSelect">
            <option selected disabled>Select</option>
            @foreach ($suppliers as $supplier)
            <option value="{{$supplier->id}}">{{$supplier->supplier_name}}</option>
            @endforeach
          </select>
        </div>

        <div class="mb-3">
          <label for="unitSelect" class="form-label">Unit Name</label>
          <select name="unit" class="form-select" id="unitSelect">
            <option selected disabled>Select</option>
            @foreach ($units as $unit)
                <option value="{{$unit->id}}">{{$unit->unit_name}}</option>
            @endforeach
          </select>
        </div>

        <div class="mb-3">
          <label for="categorySelect" class="form-label">Category Name</label>
          <select name="category" class="form-select" id="categorySelect">
            <option selected disabled>Select</option>
            @foreach ($categories as $category)
            <option value="{{$category->id}}">{{$category->category}}</option>
            @endforeach
          </select>
        </div>
        <div class="text-start">
          <button type="submit" class="btn btn-info text-white">Add product</button>
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