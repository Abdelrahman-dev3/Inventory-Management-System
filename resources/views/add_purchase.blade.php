@extends('layouts.main')

@section('title','Add Purchase')

@section('content')
<div class="container bg-white p-4 rounded shadow">
  <h5 class="mb-4">Add Purchase</h5>
  <form action="{{ route('purchase.store') }}" method="post">
    @csrf
    <div class="row mb-3">
      <div class="col-md-4">
        <label class="form-label">Supplier Name</label>
        <select name="supplier" class="form-select" id="supplierSelect">
          <option selected disabled>Select</option>
          @foreach ($suppliers as $supplier)
          <option value="{{$supplier->id}}">{{$supplier->supplier_name}}</option>
          @endforeach
        </select>
      </div>
      <div class="col-md-4">
        <label class="form-label">Description</label>
        <input type="text" name="description" placeholder="Description" class="form-control desc">
      </div>
    </div>

    <table class="table table-bordered">
      <thead class="table-light">
        <tr>
          <th>Category</th>
          <th>Product Name</th>
          <th>PSC/KG</th>
          <th>Unit Price</th>
          <th>Total Price</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody id="purchaseBody">
        <tr>
          <td>
            <select name="category[]" class="form-select category">
              <option selected disabled>Select</option>
              @foreach ($categories as $category)
              <option value="{{$category->id}}">{{$category->category}}</option>
              @endforeach
            </select>
          </td>
          <td>
            <select name="product[]" class="form-select product">
              <option selected disabled>Select</option>
              @foreach ($products as $product)
              <option value="{{$product->id}}">{{$product->product_name}}</option>
              @endforeach
            </select>
          </td>
          <td><input type="number" name="quantity[]" class="form-control qty" oninput="calcRowTotal(this)"></td>
          <td><input type="number" name="price[]" class="form-control price" oninput="calcRowTotal(this)"></td>
          <td><input type="number" name="total[]" class="form-control total" value="0" readonly></td>
          <td><button type="button" class="btn btn-danger btn-sm delete-btn">Delete</button></td>
        </tr>
      </tbody>
      <tfoot>
        <tr>
          <td colspan="4" class="text-end fw-bold">Grand Total</td>
          <td><input class="form-control" name="total_all" id="grandTotal" value="0" readonly></td>
          <td></td>
        </tr>
      </tfoot>
    </table>

    <input type="submit" value="Purchase Store" class="btn btn-info">
  </form>

  <button type="button" style="right: 27px; position: absolute;" onclick="addRow()" class="btn btn-dark mb-4">+ Add More</button>
</div>
@endsection

@section('script')
<script>
function calcRowTotal(input) {
  let row = input.closest("tr");
  let qty = parseFloat(row.querySelector(".qty").value) || 0;
  let price = parseFloat(row.querySelector(".price").value) || 0;
  let totalField = row.querySelector(".total");
  totalField.value = qty * price;

  calcGrandTotal();
}

function calcGrandTotal() {
  let grandTotal = 0;
  document.querySelectorAll(".total").forEach(input => {
    grandTotal += parseFloat(input.value) || 0;
  });
  document.getElementById("grandTotal").value = grandTotal;
}





function addRow() {
  let tbody = document.getElementById("purchaseBody");
  let row = document.createElement("tr");
  row.innerHTML = `
    <td>
      <select name="category[]" class="form-select category">
        <option selected disabled>Select</option>
        @foreach ($categories as $category)
        <option value="{{$category->id}}">{{$category->category}}</option>
        @endforeach
      </select>
    </td>
    <td>
      <select name="product[]" class="form-select product">
        <option selected disabled>Select</option>
        @foreach ($products as $product)
        <option value="{{$product->id}}">{{$product->product_name}}</option>
        @endforeach
      </select>
    </td>
    <td><input type="number" name="quantity[]" class="form-control qty" oninput="calcRowTotal(this)"></td>
    <td><input type="number" name="price[]" class="form-control price" oninput="calcRowTotal(this)"></td>
    <td><input type="number" name="total[]" class="form-control total" value="0" readonly></td>
    <td><button type="button" class="btn btn-danger btn-sm delete-btn">Delete</button></td>
  `;
  tbody.appendChild(row);
}

document.addEventListener("click", function(e) {
  if (e.target.classList.contains("delete-btn")) {
    e.target.closest("tr").remove();
    calcGrandTotal();
  }
});
</script>
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