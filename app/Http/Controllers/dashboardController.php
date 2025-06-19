<?php

namespace App\Http\Controllers;

use App\Models\Inovice;
use App\Models\Inovice_items;
use App\Models\Purchase_item;
use App\Models\Stock;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class dashboardController extends Controller
{
function dashboard() {
    $totalProfit = 0;
    $topSelling = Stock::with('product')->orderByDesc('out_qty')->take(5)->get();
    $lowSelling = Stock::with('product')->orderBy('out_qty')->take(5)->get();

    $stock = Stock::all();
    $todayInvoices = Inovice::whereDate('created_at', Carbon::today())->count();
    $total_sales = Stock::sum('out_qty');
    $todayTransactions =Transaction::whereDate('created_at', Carbon::today())->count();
    $less_stock = Stock::with('product')->where(DB::raw('in_qty - out_qty'), '<', 20)->get()->pluck('product.product_name');

    $salesPrice = Inovice_items::with('product') ->whereDate('created_at', Carbon::today())->get(['product_id', 'price' , 'quantity']);
    foreach ($salesPrice as $item) {
    $salesPrice   = $item->price;
    $quantity     = $item->quantity;
    $purchasePrice = Purchase_item::where('product_id', $item->product_id)->avg('unit_price') ?? 0;;
    $purchasePrice = $purchasePrice ?? 0;
    $profitPerUnit = $salesPrice - $purchasePrice;
    $profit = $profitPerUnit * $quantity;
    $totalProfit += $profit;
    }
    $todayDiscount = Inovice::whereDate('created_at', Carbon::today())->sum('discount');
    $totalProfit -= $todayDiscount;


$transactionsPerDay = Transaction::select(
        DB::raw('DATE(created_at) as date'),
        DB::raw('COUNT(*) as total')
    )
    ->where('created_at', '>=', Carbon::now()->subDays(6))
    ->groupBy('date')
    ->orderBy('date')
    ->get();
$dates = $transactionsPerDay->pluck('date')->toArray();
$totals = $transactionsPerDay->pluck('total')->toArray();

$orderLastSevenDays = Inovice::select(
        DB::raw('DATE(created_at) as date'),
        DB::raw('COUNT(*) as total')
    )
    ->where('created_at', '>=', Carbon::now()->subDays(6)->startOfDay())
    ->groupBy('date')
    ->orderBy('date')
    ->get()
    ->keyBy('date'); 

$dates7 = [];
$totals7 = [];

for ($i = 6; $i >= 0; $i--) {
    $date = Carbon::now()->subDays($i)->toDateString();
    $dates7[] = $date;
    $totals7[] = isset($orderLastSevenDays[$date]) ? $orderLastSevenDays[$date]->total : 0;
}





        return view("dashboard" ,['dates7' => $dates7, 'totals7' => $totals7,'dates' => $dates, 'totals' => $totals, 'lowSelling' => $lowSelling , 'topSelling' => $topSelling ,'totalProfit' => $totalProfit , 'todayInvoices' => $todayInvoices ,  'less_stock' => $less_stock , 'total_sales' => $total_sales , 'todayTransactions' => $todayTransactions]);
    }
}
