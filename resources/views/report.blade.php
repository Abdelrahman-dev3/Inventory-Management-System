@extends('layouts.main')

@section('title','report')

@section('content')
      <div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
      <h3>Stock Report</h3>
      <button onclick="printPart()" class="btn btn-dark">Stock Report Print</button>
    </div>

    <div class="mb-3">
      <input type="text" class="form-control w-25" placeholder="Search...">
    </div>

    <div id="print" class="table-responsive">
      <table  class="table table-bordered text-center align-middle">
        <thead class="table-light">
          <tr>
            <th>ID</th>
            <th>Supplier Name</th>
            <th>Category</th>
            <th>Product Name</th>
            <th>In Qty</th>
            <th>Out Qty</th>
            <th>Stock</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($stocks as $stock)
          <tr>
            <td>{{$stock->id}}</td>
            <td>
                {{$stock->supplier ? $stock->supplier->supplier_name : 'deleted'}}
            </td>
            <td>{{$stock->category  ? $stock->category->category : 'deleted'}}</td>
            <td>{{$stock->product  ? $stock->product->product_name : 'deleted'}}</td>
            <td><span class="badge bg-success">{{$stock->in_qty}}</span></td>
            <td><span class="badge bg-primary">{{$stock->out_qty}}</span></td>
            <td><span  class="badge bg-danger">{{$stock->stock}}</span></td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
  
<button onclick="addReturnRowShaw()" class="btn btn-primary mb-3">Add Returns</button>
  <button id="add" onclick="addReturnRow()" class="btn btn-secondary mb-3 d-none">Add Row</button>
<form action="{{route('report.update')}}" method="post">
  @csrf
  @method('PUT')
  <table id="tog" class="table table-bordered d-none">
    <thead>
      <tr>
        <th>Supplier Name	</th>
        <th>Category</th>
        <th>Product Name</th>
        <th>Returned Quantity</th>
        <th>Deleted</th>
      </tr>
    </thead>
    <tbody id="returnsBody">
    </tbody>
  </table>
<button type="submit" id="sure" style="position: relative;right: -93%;" class="btn btn-warning d-none">Confirm</button>
</form>
  
@endsection
@section('script')
    <script>
      function printPart() {
        var content = document.getElementById('print').innerHTML;
        var myWindow = window.open('', '', 'width=800,height=600');
myWindow.document.write('<html><head><title>Print</title>');

    myWindow.document.write(`
        <style>
            table { width: 100%; border-collapse: collapse; }
            th, td { border: 1px solid #000; padding: 8px; text-align: center; }
            th { background-color: #eee; }
            body { font-family: Arial, sans-serif; padding: 20px; }
        </style>
    `);

    myWindow.document.write('</head><body>');
        myWindow.document.write(content);
        myWindow.document.write('</body></html>');
        myWindow.document.close();
        myWindow.print();
      }

function addReturnRowShaw() {
  document.getElementById('tog').classList.toggle('d-none');
  document.getElementById('add').classList.toggle('d-none');
}

function addReturnRow() {
  let tbody = document.getElementById("returnsBody");
  let row = document.createElement("tr");

  row.innerHTML = `
    <td>
      <select name="supplier[]" class="form-select">
          <option selected disabled>Select</option>
          @foreach ($suppliers as $supplier)
          <option value="{{$supplier->id}}">{{$supplier->supplier_name}}</option>
          @endforeach
    </td>
    <td>
      <select name="category[]" class="form-select">
              <option selected disabled>Select</option>
              @foreach ($categories as $category)
              <option value="{{$category->id}}">{{$category->category}}</option>
              @endforeach
      </select>
    </td>
    <td>
      <select name="product[]" class="form-select">
              <option selected disabled>Select</option>
              @foreach ($products as $product)
              <option value="{{$product->id}}">{{$product->product_name}}</option>
              @endforeach
      </select>
    </td>
    <td>
      <input type="number" name="quantity[]" class="form-control" placeholder="Quantity">
    </td>
    <td>
      <button type="button" class="btn btn-danger btn-sm" onclick="deleteRow(this)">Delete</button>
    </td>
  `;

  tbody.appendChild(row);
  updateSureButton();
}

  function deleteRow(button) {
    button.closest('tr').remove();
    updateSureButton();
  }

function updateSureButton() {
  let tbody = document.getElementById('returnsBody');
  let trCount = tbody.querySelectorAll('tr').length;
  let sureBtn = document.getElementById('sure');
  if (trCount >= 1) {
    sureBtn.classList.remove('d-none'); 
  } else {
    sureBtn.classList.add('d-none'); 
  }
}

@if(session('success'))
    toastr.options = {
        "closeButton": true,
        "progressBar": true,
        "timeOut": "2000",
        "extendedTimeOut": "3000"
    }
    toastr.success("{{ session('success') }}");
@endif

@if ($errors->any())
    toastr.options = {
        "closeButton": true,
        "progressBar": true,
        "timeOut": "10000",
        "extendedTimeOut": "5000"   
    };

    @foreach ($errors->all() as $error)
        toastr.error("{{ $error }}");
    @endforeach
@endif
    </script>
@endsection


