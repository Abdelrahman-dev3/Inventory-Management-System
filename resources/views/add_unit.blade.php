@extends('layouts.main')

@section('title', 'Add Unit')

@section('content')
  <div class="container my-5">
    <div class="card shadow p-4">
      <h4 class="mb-4">Add Unit Page</h4>
      <form method="POST" action="{{ route('unit.store') }}">
        @csrf
        <div class="mb-3 row">
          <label for="unitName" class="col-sm-2 col-form-label">Unit Name</label>
          <div class="col-sm-10">
            <input name="unit_name" type="text" class="form-control" id="unitName" placeholder="Enter Unit name">
          </div>
        </div>
        <div class="text-start">
          <input value="Add Unit" type="submit" class="btn btn-info text-white">
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