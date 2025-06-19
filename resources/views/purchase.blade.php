@extends('layouts.main')

@section('title','Purchase')

@section('content')
      <div class="container my-5">
    <div class="d-flex justify-content-between align-items-center mb-3">
    </div>
    <div class="row mb-3">
      <div class="col-md-6">
      <a href="{{ route('add_purchase') }}" class="btn btn-dark"><i class="bi bi-plus-circle"></i> Add Purchase</a>
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
          <th>Purchase No</th>
          <th>Date</th>
          <th>Supplier</th>
          <th>Description</th>
          {{-- <th>Status</th> --}}
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($purchase as $purchase)
        <tr>
          <td>PUR-{{$purchase->id}}</td>
          <td>{{$purchase->created_at->format('d-m-Y')}}</td>
          <td>{{$purchase->supplier  ? $purchase->supplier->supplier_name : 'deleted'}}</td>
          <td>{{$purchase->description}}</td>
          {{-- <td>
              @if ($purchase->status == 0)
                  <form action="{{ route('purchase.status', $purchase->id) }}" method="POST" style="display: inline;">
                      @csrf
                      @method('PUT')
                      <button type="submit" class="btn btn-warning btn-sm"><strong>Pending</strong></button>
                  </form>
              @else
                <button class="btn btn-success btn-sm"><strong>Completed</strong></button>
              @endif
          </td> --}}  {{-- stutus --}}  
          <td style="text-align: center;display: flex;justify-content: space-evenly;">
            <a href="{{route('purchase.view' , $purchase->id)}}" class="btn btn-info btn-sm">view</a>
            <form action="{{route('purchase.destroy', $purchase->id )}}" method="post">
              @method('DELETE')
              @csrf
              <button style="display: inline;" type="submit" class="btn btn-danger btn-sm">delete</button>
            </form>

            <a href="{{route('purchase.edit' , $purchase->id)}}" class="btn btn-success btn-sm">edit</a>
            
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>

@endsection