@extends('layouts.main')

@section('title','inovice')

@section('content')
      <div class="container my-5">
    <div class="d-flex justify-content-between align-items-center mb-3">
    </div>

    <div class="row mb-3">
      <div class="col-md-6">
      <a href="{{ route('add_inovice') }}" class="btn btn-dark"><i class="bi bi-plus-circle"></i> Add inovice</a>
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
          <th>invoice No</th>
          <th>Customer Name</th>
          <th>Date</th>
          <th>Description</th>
          <th>Amount</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($inovices as $inovice)
        <tr>
          <td>INV-{{$inovice->id}}</td>
          <td>{{$inovice->customer->customer_name}}</td>
          <td>{{$inovice->created_at->format('d-m-Y')}}</td>
          <td>{{$inovice->discreption}}</td>
          <td>{{$inovice->total_after_discount}}</td>
          <td  style="text-align: center;display: flex;justify-content: space-evenly;">
            
            <a href="{{route('inovice.view' , $inovice->id)}}" class="btn btn-info btn-sm">view</a>
            
            <form action="{{route('inovice.destroy', $inovice->id )}}" method="post">
              @method('DELETE')
              @csrf
              <button style="display: inline;" type="submit" class="btn btn-danger btn-sm">delete</button>
            </form>
            <a href="{{route('inovice.edit' , $inovice->id)}}" class="btn btn-success btn-sm">edit</a>
            
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