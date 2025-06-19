@extends('layouts.main')

@section('title','  Product')

@section('content')
      <div class="container my-5">
    <div class="d-flex justify-content-between align-items-center mb-3">
    </div>

    <div class="row mb-3">
      <div class="col-md-6">
      <a href="{{ route('add_product') }}" class="btn btn-dark"><i class="bi bi-plus-circle"></i> Add Product</a>
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
          <th>Supplier Name</th>
          <th>Unit</th>
          <th>Category</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($products as $product)
        <tr>
          <td>{{$product->id}}</td>
          <td>{{$product->product_name}}</td>
          <td>{{$product->supplier  ? $product->supplier->supplier_name : 'deleted'}}</td>
          <td>{{$product->unit ? $product->unit->unit_name : 'deleted'}}</td>
          <td>{{$product->category ? $product->category->category : 'deleted'}}</td>
          <td style="text-align: center;display: flex;justify-content: space-evenly;">
            <form action="{{route('product.destroy', $product->id )}}" method="post">
              @method('DELETE')
              @csrf
              <button style="display: inline;" type="submit" class="btn btn-danger btn-sm">delete</button>
            </form>
            <a class="btn btn-success btn-sm" href="{{ route('product.edit',$product->id) }}">edit</a>
            
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