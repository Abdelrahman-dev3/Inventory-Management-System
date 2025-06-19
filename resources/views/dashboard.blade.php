@extends('layouts.main')

@section('title', 'Dashboard')

@section('content')
  <div class="container-fluid my-4">
    <div class="row g-3">
      <div class="col-md-3">
        <div class="card p-3">
          <div class="d-flex justify-content-between align-items-center">
            <div>
              <h3 class="text-muted mb-1">Total Sales</h3>
              <hr>
                <h6 class="fw-bold fs-4 text-center">{{$total_sales}}</h6>
            </div>
            <i class="fas fa-cart-shopping fs-3 bg-light p-2 rounded-circle text-secondary"></i>
          </div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="card p-3">
          <div class="d-flex justify-content-between align-items-center">
            <div>
              <h3 class="text-muted mb-1">Movement Today</h3>
              <hr>
              <h6 class="fw-bold fs-4 text-center">{{$todayTransactions}}</h6>
            </div>
            <i class="fas fa-exchange-alt fs-3 bg-light p-2 rounded-circle text-secondary"></i>
          </div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="card p-3">
          <div class="d-flex justify-content-between align-items-center">
            <div>
              <h3 class="text-muted mb-1">Invoice Today</h3>
              <hr>
                <h6 class="fw-bold fs-4 text-center">{{$todayInvoices}}</h6>
            </div>
            <i class="fas fa-file-invoice fs-3 bg-light p-2 rounded-circle text-secondary"></i>
          </div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="card p-3">
          <div class="d-flex justify-content-between align-items-center">
            <div>
              <h3 class="text-muted mb-1">AVG Profit Today</h3>
              <hr>
                <h6 style="color: green" class="fw-bold fs-4 text-center">{{$totalProfit}}</h6>
            </div>
            <i class="fas fa-dollar-sign fs-3 bg-light p-2 rounded-circle text-secondary"></i>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="row mb-4">
    <div class="col-md-6">
      <canvas id="barChart"></canvas>
    </div>



    <div class="col-md-6">
      <canvas id="simpleLineChart"></canvas>
    </div>


  </div>

<div class="card mb-4">
  <div class="card-header"> Top & Low Selling Products</div>
  <div class="card-body">
    <div class="row">
      <div class="col-md-6">
        <h6><i class="fas fa-arrow-up text-success"></i> Top Selling</h6>
        <table class="table table-bordered table-hover">
          <thead class="table-success">
            <tr>
              <th>Product</th>
              <th>Sold Qty</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($topSelling as $item)
            <tr>
              <td>{{$item->product->product_name}}</td>
              <td>{{$item->out_qty}}</td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>

      <div class="col-md-6">
        <h6><i class="fas fa-arrow-down text-danger"></i> Low Selling</h6>
        <table class="table table-bordered table-hover">
          <thead class="table-danger">
            <tr>
              <th>Product</th>
              <th>Sold Qty</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($lowSelling as $item)
            <tr>
              <td>{{$item->product ? $item->product->product_name : 'delete'}}</td>
              <td>{{$item->out_qty}}</td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
  <div class="card mt-4 mb-4">
    <div class="card-header bg-white">
      <strong><i class="fa-solid fa-bell"></i> Notifications </strong>
    </div>
    <div class="card-body">
      <ul>
        @foreach ($less_stock as $item)
          <li>Product <strong>{{$item}}</strong> Less than 20 pieces</li>
        @endforeach
      </ul>
    </div>
  </div>
@endsection

@section('script')
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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

    // Bar Chart
const barCtx = document.getElementById('barChart');
new Chart(barCtx, {
  type: 'bar',
  data: {
    labels: {!! json_encode($dates) !!},
    datasets: [{
      label: 'Transactions',
      data: {!! json_encode($totals) !!},
      backgroundColor: '#0d6efd'
    }]
  },
  options: {
    responsive: true,
    plugins: { legend: { display: false } }
  }
});

// Pie Chart
const pieCtx = document.getElementById('pieChart');
new Chart(pieCtx, {
  type: 'pie',
  data: {
    labels: ['Available Stock', 'Low Stock'],
    datasets: [{
      data: [50, 5],
      backgroundColor: ['#198754', '#dc3545']
    }]
  },
  options: {
    responsive: true
  }
});
let dates2 = @json($dates7);
let totals2 = @json($totals7);

    new Chart(document.getElementById("simpleLineChart"), {
      type: 'line',
      data: {
        labels: dates2,
        datasets: [{
          label: "Number of orders",
          data: totals2,
          borderColor: "#3498db",
          backgroundColor: "rgba(52,152,219,0.2)",
          fill: true,
          tension: 0.3
        }]
      },
      options: {
        scales: {
          y: { beginAtZero: true }
        }
      }
    });
</script>
@endsection