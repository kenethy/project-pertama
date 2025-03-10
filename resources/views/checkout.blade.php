@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-8">
    <!-- Judul Checkout -->
    <h2 class="text-2xl font-bold mb-6 text-gray-800">Checkout</h2>

    <div class="grid md:grid-cols-3 gap-6">
        <!-- Kolom Kiri: Form Informasi Pelanggan -->
        <div class="md:col-span-2 bg-white p-6 shadow-md rounded-lg">
            <h3 class="text-lg font-semibold mb-4 text-gray-700">Informasi Pelanggan</h3>
            <form id="checkoutForm" action="{{ route('order.confirm') }}" method="POST">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label class="block text-gray-600 text-sm">Nama Lengkap</label>
                        <input type="text" name="name" required class="w-full p-2 border rounded-lg focus:ring focus:ring-blue-300">
                    </div>
                    <div>
                        <label class="block text-gray-600 text-sm">Email</label>
                        <input type="email" name="email" required class="w-full p-2 border rounded-lg focus:ring focus:ring-blue-300">
                    </div>
                    <div>
                        <label class="block text-gray-600 text-sm">Nomor Telepon</label>
                        <input type="text" name="phone" required class="w-full p-2 border rounded-lg focus:ring focus:ring-blue-300">
                    </div>
                    <div>
                        <label class="block text-gray-600 text-sm">Alamat Lengkap</label>
                        <textarea name="address" required class="w-full p-2 border rounded-lg focus:ring focus:ring-blue-300"></textarea>
                    </div>
                    <!-- Menyimpan data keranjang (dikirim dalam format JSON) -->
                    <input type="hidden" name="cartData" value="{{ json_encode($cartData) }}">
                </div>
            </form>
        </div>

        <!-- Kolom Kanan: Ringkasan Pesanan -->
        <div class="bg-white p-6 shadow-md rounded-lg">
            <h3 class="text-lg font-semibold mb-4 text-gray-700">Ringkasan Pesanan</h3>
            <div class="space-y-4">
                @php 
                    $total = 0;
                @endphp
                @foreach ($cartData as $item)
                    @php
                        // Pastikan harga dan kuantitas dikonversi ke tipe numerik
                        $price    = floatval(preg_replace('/[^\d]/', '', $item['price']));
                        $quantity = intval($item['quantity']);
                        $itemTotal = $price * $quantity;
                        $total += $itemTotal;
                    @endphp
                    <div class="flex justify-between border-b pb-2">
                        <div>
                            <p class="text-gray-800 font-semibold">{{ $item['name'] }}</p>
                            <p class="text-gray-600 text-sm">
                                {{ $quantity }}x Rp {{ number_format($price, 0, ',', '.') }}
                            </p>
                        </div>
                        <p class="text-gray-800">Rp {{ number_format($itemTotal, 0, ',', '.') }}</p>
                    </div>
                @endforeach
            </div>
            <!-- Total Harga Pesanan -->
            <div class="flex justify-between mt-4 text-lg font-bold text-gray-800">
                <span>Total:</span>
                <span>Rp {{ number_format($total, 0, ',', '.') }}</span>
            </div>
            <!-- Tombol Konfirmasi Pesanan -->
            <button type="submit" form="checkoutForm"
                class="w-full bg-green-500 hover:bg-green-600 text-white py-2 px-4 rounded-lg mt-4">
                Konfirmasi Pesanan
            </button>
            <!-- Tombol Kembali ke Etalase -->
            <a href="{{ route('etalase') }}"
               class="w-full bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded-lg mt-2 inline-block text-center">
                Kembali ke Etalase
                <div style="font-weight: bold">
                    (Reset Keranjang)
                </div>
            </a>
        </div>
    </div>
</div>
@endsection
@php 
$activePage = 'etalase';
@endphp