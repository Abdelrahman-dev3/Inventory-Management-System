    @extends('layouts.main')

    @section('title','View Inovice')

    @section('content')
    @foreach ($invoices as $invoice)
                <div class="card shadow p-4 my-box mb-4" id="print" onclick="this.classList.toggle('active_inv')">
            <div class="d-flex justify-content-between fw-bold">
                <span style="position: relative;top: -9px;">INV-NO:{{$invoice->id}}</span>
                <span style="position: relative;top: -9px;">DATE: {{$invoice->created_at->format('d/m/Y')}}</span>
            </div>
            <button onclick="printPart()" style="width: 15%;position: relative;right: -957px;top: 1px;" class="btn btn-dark">Stock Report Print</button>
            <h3 class="fw-bold mt-1 mb-4 text-center">Customer INFO</h3>
            <div class="info d-flex justify-content-between">
                <h6 class="fw-bold">Customer Name: <span>{{$invoice->customer->customer_name}}</span></h6>
                <h6 class="fw-bold">Customer Email: <span>{{$invoice->customer->email}}</span></h6>
                <h6 class="fw-bold">Customer Address: <span>{{$invoice->customer->address}}</span></h6>
            </div>
            <hr>
            <h3 class="fw-bold mt-1 mb-4 text-center desc">Description</h3>
            <span>{{$invoice->discreption}}</span>
            <hr>
            <table class="table table-bordered table-striped text-center align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Id</th>
                        <th>Category</th>
                        <th>Product</th>
                        <th>QTY</th>
                        <th>Price</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($invoice_items as $item)
                    <tr>
                        <td style="text-align: center;">{{$item->id}}</td>
                        <td style="text-align: center;">{{$item->category ? $item->category->category    : 'deleted'}}</td>
                        <td style="text-align: center;">{{$item->product  ? $item->product->product_name : 'deleted'}}</td>
                        <td>{{$item->quantity}}</td>
                        <td>{{$item->price}}</td>
                        <td>{{$item->total_all}}</td>
                    </tr>
                    @endforeach
                    <tr>
                        <td colspan="5" class="text-end fw-bold">Total Before Discount</td>
                        <td style="text-align: center;">{{$invoice->total_before_discount}}</td>
                    </tr>
                    <tr>
                        <td colspan="5" class="text-end fw-bold">Discount</td>
                        <td style="text-align: center;">{{$invoice->discount}}</td>
                    </tr>
                    <tr>
                        <td colspan="5" class="text-end fw-bold">Total After Discount</td>
                        <td style="text-align: center;">{{$invoice->total_after_discount}}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    @endforeach

    @endsection

    @section('script')
<script>
function printPart() {
    var content = document.getElementById('print').innerHTML;
    var myWindow = window.open('', '', 'width=800,height=600');
    myWindow.document.write(`
        <html>
            <head>
                <title>Invoice Print</title>
                <style>
                    body { font-family: Arial, sans-serif; padding: 20px; text-align: center; }
                    table { width: 100%; border-collapse: collapse; margin-top: 20px; }
                    th, td { border: 1px solid #000; padding: 8px; text-align: center; }
                    th { background-color: #eee; }
                    h3 { margin-bottom: 10px; }
                    .info h6 { margin: 5px 0; font-size: 17px}
                    .fw-bold { font-weight: bold; }
                </style>
            </head>
            <body>
                ${content}
            </body>
        </html>
    `);
    myWindow.document.close();
    myWindow.focus();
    myWindow.print();
    myWindow.close();
}
</script>
@endsection