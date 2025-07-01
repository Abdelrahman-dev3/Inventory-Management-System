@extends('layouts.main')

@section('title', 'Add category')

@section('content')
  <div class="container my-5">
    <div class="card shadow p-4">
      <h4 class="mb-4">Add category Page</h4>
      <form action="{{ route('category.store') }}" method="POST">
        @csrf
        <div class="mb-3 row">
          <label for="categoryName" class="col-sm-2 col-form-label">category Name</label>
          <div class="col-sm-10">
            <input type="text" name="category" value="{{old('category')}}" class="form-control" id="categoryName" placeholder="Enter category name">
          </div>
        </div>
        <div class="text-start">
          <button type="submit" class="btn btn-info text-white">Add category</button>
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