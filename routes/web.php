<?php

use App\Http\Controllers\signupController;
use App\Http\Controllers\loginController;
use App\Http\Controllers\dashboardController;
use App\Http\Controllers\supplierController;
use App\Http\Controllers\customerController;
use App\Http\Controllers\categoryController;
use App\Http\Controllers\unitController;
use App\Http\Controllers\productController;
use App\Http\Controllers\purchaseController;
use App\Http\Controllers\inoviceController;
use App\Http\Controllers\reportController;
use App\Http\Controllers\profileController;
use Illuminate\Support\Facades\Route;

Route::get('/', [signupController::class,"signup"]);

Route::get('/signup',[signupController::class,"signup"])->name('signup');

Route::post('/signup',[signupController::class,"store"])->name("signup.store");

Route::get('/login',[loginController::class,"login"])->name('login');

Route::post('/login',[loginController::class,"regester"])->name('regester');


Route::middleware(['auth'])->group(function () {

Route::get('/dashboard',[dashboardController::class,"dashboard"])->name('dashboard');

Route::get('/profile',[profileController::class,"profile"])->name('profile');

Route::get('/edit/profile',[profileController::class,"profile_edit"])->name('profile_edit');

Route::put('/profile',[profileController::class,"update"])->name('profile.update');

Route::put('/profile/changepass',[profileController::class,"changepass"])->name("profile.changepass");

















Route::get('/supplier',[supplierController::class,"supplier"])->name('supplier');

Route::get('add/supplier',[supplierController::class,"add_supplier"])->name('add_supplier');

Route::post('/supplier',[supplierController::class,"store"])->name("supplier.store");

Route::delete('/supplier/{id}',[supplierController::class,"destroy"])->name("supplier.destroy");

Route::get('/supplier/{supplier}/edit',[supplierController::class,"edit"])->name("supplier.edit");

Route::put('/supplier',[supplierController::class,"update"])->name("supplier.update");













Route::get('/customer',[customerController::class,"customer"])->name('customer');

Route::get('/add/customer',[customerController::class,"add_customer"])->name('add_customer');

Route::post('/customer',[customerController::class,"store"])->name("customer.store");

Route::delete('/customer/{id}',[customerController::class,"destroy"])->name("customer.destroy");

Route::get('/customer/{customer}/edit',[customerController::class,"edit"])->name("customer.edit");

Route::put('/customer',[customerController::class,"update"])->name("customer.update");

Route::get('/customer/{customer}/view',[customerController::class,"view"])->name('customer.view');
















Route::get('/unit',[unitController::class,"unit"])->name('unit');

Route::get('/add/unit',[unitController::class,"add_unit"])->name('add_unit');

Route::post('/unit',[unitController::class,"store"])->name('unit.store');

Route::delete('/unit/{id}',[unitController::class,"destroy"])->name("unit.destroy");




















Route::get('/category',[categoryController::class,"category"])->name('category');

Route::get('/add/category',[categoryController::class,"add_category"])->name('add_category');

Route::post('/category',[categoryController::class,"store"])->name('category.store');

Route::delete('/category/{id}',[categoryController::class,"destroy"])->name("category.destroy");

















Route::get('/product',[productController::class,"product"])->name('product');

Route::get('/add/product',[productController::class,"add_product"])->name('add_product');

Route::post('/product',[productController::class,"store"])->name('product.store');

Route::delete('/product/{id}',[productController::class,"destroy"])->name("product.destroy");

Route::get('/product/{product}/edit',[productController::class,"edit"])->name("product.edit");

Route::put('/product',[productController::class,"update"])->name("product.update");














Route::get('/purchase',[purchaseController::class,"purchase"])->name('purchase');

Route::get('/add/purchase',[purchaseController::class,"add_purchase"])->name('add_purchase');

Route::post('/purchase',[purchaseController::class,"store"])->name('purchase.store');

Route::delete('/purchase/{id}',[purchaseController::class,"destroy"])->name("purchase.destroy");

Route::get('/purchase/{purchase}/view',[purchaseController::class,"view"])->name("purchase.view");

Route::get('/purchase/{purchase}/edit',[purchaseController::class,"edit"])->name("purchase.edit");

Route::put('/purchase/{id}',[purchaseController::class,"update"])->name("purchase.update");

Route::put('/purchase/{id}/status',[purchaseController::class,"status"])->name("purchase.status");











Route::get('/inovice',[inoviceController::class,"inovice"])->name('inovice');

Route::get('/add/inovice',[inoviceController::class,"add_inovice"])->name('add_inovice');

Route::post('/inovice',[inoviceController::class,"store"])->name('inovice.store');

Route::delete('/inovice/{id}',[inoviceController::class,"destroy"])->name("inovice.destroy");

Route::get('/inovice/{id}/view',[inoviceController::class,"view"])->name("inovice.view");

Route::get('/inovice/{invoice}/edit',[inoviceController::class,"edit"])->name("inovice.edit");

Route::put('/inovice',[inoviceController::class,"update"])->name("inovice.update");







Route::get('/report',[reportController::class,"report"])->name('report');

Route::get('/add/report',[reportController::class,"add_report"])->name('add_report');

Route::put('/report/update', [reportController::class, 'update'])->name('report.update');

});
