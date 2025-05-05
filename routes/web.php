<?php

use App\Models\Order;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/admin/orders/{order}', function (Order $order) {
    return view('print.order', compact('order'));
})->name('orders.print')->middleware(['auth']);
