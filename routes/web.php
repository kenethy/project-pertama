<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');

})->name('home');

Route::get('/etalase', function()
{
    return view('etalase');
})->name('etalase');

Route::post('/checkout', function (\Illuminate\Http\Request $request) {
    $cartData = json_decode($request->input('cartData'), true);
    // Lakukan proses checkout atau lempar data ke view checkout
    return view('checkout', compact('cartData'));
})->name('checkout');


Route::post('/order-confirm', function (\Illuminate\Http\Request $request) {
    $cartData = json_decode($request->input('cartData'), true);
    $customer = [
        'name' => $request->input('name'),
        'email' => $request->input('email'),
        'phone' => $request->input('phone'),
        'address' => $request->input('address'),
    ];
    
    // Simpan order ke database (opsional)
    // Order::create([...]);

    return view('order-success', compact('cartData', 'customer'));
})->name('order.confirm');
