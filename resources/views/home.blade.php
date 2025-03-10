@extends('layouts.app')

@section('title', 'Home')

@section('content')
    <!-- HERO SECTION -->
    <section class="bg-blue-50 py-12">
        <div class="container mx-auto px-4 text-center">
            <h1 class="text-4xl font-bold text-gray-800">Selamat Datang di Website Kami</h1>
            <p class="mt-4 text-lg text-gray-600">
                Temukan produk terbaik dengan kualitas unggul dan penawaran menarik.
            </p>
            <a href="{{ route('etalase') }}" class="mt-6 inline-block bg-blue-500 hover:bg-blue-600 text-white py-2 px-6 rounded">
                Lihat Etalase
            </a>
        </div>
    </section>

    <!-- FEATURED PRODUCTS SECTION -->
    <section class="py-12">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold text-gray-800 text-center mb-8">Produk Unggulan</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Contoh Kartu Produk (bisa dikembangkan) -->
                <div class="bg-white rounded-lg shadow p-4">
                    <img src="https://via.placeholder.com/300x200" alt="Produk 1" class="w-full h-40 object-cover rounded">
                    <h3 class="mt-4 text-xl font-semibold text-gray-800">Produk 1</h3>
                    <p class="mt-2 text-gray-600">Deskripsi singkat produk.</p>
                    <span class="block mt-2 font-bold text-blue-500">Rp100.000</span>
                </div>
                <div class="bg-white rounded-lg shadow p-4">
                    <img src="https://via.placeholder.com/300x200" alt="Produk 2" class="w-full h-40 object-cover rounded">
                    <h3 class="mt-4 text-xl font-semibold text-gray-800">Produk 2</h3>
                    <p class="mt-2 text-gray-600">Deskripsi singkat produk.</p>
                    <span class="block mt-2 font-bold text-blue-500">Rp200.000</span>
                </div>
                <div class="bg-white rounded-lg shadow p-4">
                    <img src="https://via.placeholder.com/300x200" alt="Produk 3" class="w-full h-40 object-cover rounded">
                    <h3 class="mt-4 text-xl font-semibold text-gray-800">Produk 3</h3>
                    <p class="mt-2 text-gray-600">Deskripsi singkat produk.</p>
                    <span class="block mt-2 font-bold text-blue-500">Rp150.000</span>
                </div>
                <div class="bg-white rounded-lg shadow p-4">
                    <img src="https://via.placeholder.com/300x200" alt="Produk 4" class="w-full h-40 object-cover rounded">
                    <h3 class="mt-4 text-xl font-semibold text-gray-800">Produk 4</h3>
                    <p class="mt-2 text-gray-600">Deskripsi singkat produk.</p>
                    <span class="block mt-2 font-bold text-blue-500">Rp250.000</span>
                </div>
            </div>
            <div class="text-center mt-8">
                <a href="{{ route('etalase') }}" class="inline-block bg-blue-500 hover:bg-blue-600 text-white py-2 px-6 rounded">
                    Lihat Semua Produk
                </a>
            </div>
        </div>
    </section>

    <!-- ABOUT / WHY CHOOSE US SECTION -->
    <section class="bg-gray-100 py-12">
        <div class="container mx-auto px-4 text-center">
            <h2 class="text-3xl font-bold text-gray-800 mb-4">Kenapa Memilih Kami?</h2>
            <div class="flex flex-col md:flex-row justify-center items-center gap-8">
                <div class="flex flex-col items-center">
                    <span class="text-4xl">🚚</span>
                    <p class="mt-2 text-gray-600">Gratis Ongkir</p>
                </div>
                <div class="flex flex-col items-center">
                    <span class="text-4xl">⭐</span>
                    <p class="mt-2 text-gray-600">Produk Terbaik</p>
                </div>
                <div class="flex flex-col items-center">
                    <span class="text-4xl">💰</span>
                    <p class="mt-2 text-gray-600">Harga Terjangkau</p>
                </div>
            </div>
        </div>
    </section>
@endsection


@php
    $activePage = 'home';
@endphp