@extends("layouts.main")

@section('title', 'Add Inovice')

@section('content')
    
  <div class="container">
    <h3 class="mb-4">Invoice Entry</h3>
    
    <div class="col-md-1 d-flex align-items-end">
      <button onclick="addRow()" class="btn btn-primary w-100">Add</button>
      
    </div>
    <form action="{{ route('inovice.update') }}" method="post">
      @csrf
      @method('PUT')
    <table class="table table-bordered">
      <thead>
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
            @foreach ($invoice_items as $item)
            <tr>
                <td>
                    <select name="category[]" class="form-select category">
                    <option selected disabled>Select</option>
                    @foreach ($categories as $category)
                    <option @selected($category->id == $item->category_id) value="{{$category->id}}">{{$category->category}}</option>
                    @endforeach
                    </select>
                </td>
                <td>
                    <select name="product[]" class="form-select product">
                    <option selected disabled>Select</option>
                    @foreach ($products as $product)
                    <option @selected($product->id == $item->product_id) value="{{$product->id}}">{{$product->product_name}}</option>
                    @endforeach
                    </select>
                </td>
                <td><input type="number" value="{{$item->quantity}}" name="quantity[]" class="form-control qty" oninput="calcRowTotal(this)" placeholder="Quantity"></td>
                <td><input type="number" value="{{$item->price}}" name="price[]" class="form-control price" oninput="calcRowTotal(this)" placeholder="Price"></td>
                <td><input type="number" value="{{$item->total_all}}" name="total[]" class="form-control total"  readonly></td>
                <td><button type="button" class="btn btn-danger btn-sm delete-btn">Delete</button></td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="row mb-3">
      <div class="col-md-3">
        <label class="form-label">Discount</label>
        <input type="number" value="{{$invoice->discount}}" name="discount" oninput="applyDiscount()" id="discountField" class="form-control" placeholder="Discount">
      </div>
      <div class="col-md-3">
        <label class="form-label">Grand Total</label>
        <input type="number" value="{{$invoice->total_before_discount}}" name="total_before_discount" id="grandTotal" class="form-control" value="0" readonly>
      </div>
      <div class="col-md-3">
        <label class="form-label">Total After Discount</label>
        <input type="number" value="{{$invoice->total_after_discount}}" name="total_after_discount" id="TotalAfterDiscount" class="form-control" value="0" readonly>
        <input type="hidden" value="{{$invoice->id}}" name="id">
      </div>
    </div>

    <div class="mb-3">
      <label class="form-label">Description</label>
      <textarea name="description" class="form-control">{{$invoice->discreption}}</textarea>
    </div>

    <div class="row mb-3">
      <div class="col-md-3">
        <label class="form-label">Paid Status</label>
        <select name="paid_Status" class="form-select">
          <option selected disabled>Select</option>
          <option @selected($invoice->paid_status == 0) value="0">Unpaid</option>
          <option @selected($invoice->paid_status == 1) value="1">Paid</option>
        </select>
      </div>
      <div class="col-md-3">
        <label class="form-label">Customer Name</label>
            <select name="customer" class="form-select customer">
              <option selected disabled>Select</option>
              @foreach ($customers as $customer)
              <option @selected($customer->id == $invoice->customer_id) value="{{$customer->id}}">{{$customer->customer_name}}</option>
              @endforeach
            </select>
      </div>
    </div>

    <input type="submit" value="Invoice Update" class="btn btn-success">
  </form>
  </div>
  
  @if (session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif
@endsection

@section('script')
<script>
function calcRowTotal(input) {
  let row = input.closest("tr");
  let qty = parseFloat(row.querySelector(".qty").value) || 0;
  let price = parseFloat(row.querySelector(".price").value) || 0;
  let totalField = row.querySelector(".total");
  totalField.value = qty * price ;
  calcGrandTotal();


}


function calcGrandTotal() {
  let grandTotal = 0;
  document.querySelectorAll(".total").forEach(input => {
    grandTotal += parseFloat(input.value) || 0;
  });
  document.getElementById("grandTotal").value = grandTotal;

  applyDiscount();

}

function applyDiscount() {
  let originalTotal = parseFloat(document.getElementById("grandTotal").value) || 0;
  let discount = parseFloat(document.getElementById("discountField").value) || 0;
  let finalTotal = originalTotal - discount;
  document.getElementById("TotalAfterDiscount").value = finalTotal;
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
          <td><input type="number" name="quantity[]" class="form-control qty" oninput="calcRowTotal(this)" placeholder="Quantity"></td>
          <td><input type="number" name="price[]" class="form-control price" oninput="calcRowTotal(this)" placeholder="Price"></td>
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