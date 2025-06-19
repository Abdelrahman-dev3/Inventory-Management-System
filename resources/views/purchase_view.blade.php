@extends('layouts.main')

@section('title','Purchase')

@section('content')
        @foreach ($purchases as $purchase)
            <div class="card shadow p-4 my-box mb-4" id="print">
            <div class="d-flex justify-content-between fw-bold">
                <span style="position: relative;top: -9px;">PUR-NO: {{$purchase->id}}</span>
                <span style="position: relative;top: -9px;">DATE: {{$purchase->created_at->format('d/m/Y')}}</span>
            </div>
            <button onclick="printPart()" style="width: 15%;position: relative;right: -957px;top: 1px;" class="btn btn-dark">Stock Report Print</button>
            <h3 class="fw-bold mt-1 mb-4 text-center">Sipplier INFO</h3>
            <div class="info d-flex justify-content-between">
                <h6 class="fw-bold">Sipplier Name: ({{$purchase->supplier  ? $purchase->supplier->supplier_name : 'deleted'}})<span></span></h6>
                <h6 class="fw-bold">Sipplier Mobile: ({{$purchase->supplier  ? $purchase->supplier->supplier_mobile : 'deleted'}})<span></span></h6>
                <h6 class="fw-bold">Sipplier Email: ({{$purchase->supplier  ? $purchase->supplier->supplier_email : 'deleted'}})<span></span></h6>
                <h6 class="fw-bold">Sipplier Address: ({{$purchase->supplier  ? $purchase->supplier->supplier_address : 'deleted'}})<span></span></h6>
            </div>
            <hr>
            <h3 class="fw-bold mt-1 mb-4 text-center desc">Description</h3>
            <span>{{$purchase->description}}</span>
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
                    @foreach ($purchase_item as $item)
                    <tr>
                        <td style="text-align: center;">{{$item->id}}</td>
                        <td style="text-align: center;">{{$item->category  ? $item->category->category : 'deleted'}}</td>
                        <td style="text-align: center;">{{$item->product  ? $item->Product->product_name : 'deleted'}}</td>
                        <td style="text-align: center;">{{$item->quantity}}</td>
                        <td style="text-align: center;">{{$item->unit_price}}</td>
                        <td style="text-align: center;">{{$item->total_price}}</td>
                    </tr>
                    @endforeach
                    <tr>
                        <td colspan="5" class="text-end fw-bold">Total</td>
                        <td style="text-align: center;">{{$purchase->total_amount}}</td>
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