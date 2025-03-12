@extends('layouts.app')

@section('content')
<style>
    /* Styling Umum */
    body {
        font-family: 'Poppins', sans-serif;
        background-color: #111;
        color: #ddd;
        margin: 0;
        padding: 0;
        overflow-x: hidden;
    }

    /* Elemen Heading */
    h1, h2, h3, h4, h5, h6 {
        font-weight: 700;
        color: white;
    }

    /* Input dan textarea */
    input, textarea {
        font-family: 'Poppins', sans-serif;
        background-color: #222;
        color: white;
        border: 1px solid #444;
        padding: 10px;
        border-radius: 5px;
        width: 100%;
    }

    input::placeholder, textarea::placeholder {
        color: #888;
    }

    /* Tombol */
    .btn {
        font-weight: 600;
        padding: 10px 15px;
        border-radius: 5px;
        text-align: center;
        display: inline-block;
        width: 100%;
        margin-top: 10px;
    }

    .btn-orange {
        background-color: #ff5722;
        color: white;
    }

    .btn-orange:hover {
        background-color: #e64a19;
    }

    .btn-green {
        background-color: #4CAF50;
        color: white;
    }

    .btn-green:hover {
        background-color: #388E3C;
    }

    /* Ringkasan Pesanan */
    .text-white {
        color: white !important;
    }

    .text-gray {
        color: #bbb !important;
    }

    /* Canvas untuk Bintang */
    #starsCanvas {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: -1;
    }

    /* Modal Success */
    .modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.7);
        justify-content: center;
        align-items: center;
    }

    .modal-content {
        background: #222;
        padding: 20px;
        border-radius: 10px;
        text-align: center;
        color: white;
        width: 80%;
        max-width: 400px;
    }

    .modal-content h2 {
        color: #4CAF50;
    }

</style>

<!-- Canvas untuk Bintang -->
<canvas id="starsCanvas"></canvas>

<div class="max-w-4xl mx-auto px-4 py-8">
    <h2 class="text-2xl font-bold mb-6 text-white">Checkout</h2>

    <div class="grid md:grid-cols-3 gap-6">
        <!-- Form Pelanggan -->
        <div class="md:col-span-2 bg-gray-800 p-6 shadow-md rounded-lg">
            <h3 class="text-lg font-semibold mb-4 text-white">Informasi Pelanggan</h3>
            <form id="checkoutForm" action="{{ route('order.confirm') }}" method="POST">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label class="text-gray text-sm">Nama Lengkap</label>
                        <input type="text" name="name" required>
                    </div>
                    <div>
                        <label class="text-gray text-sm">Email</label>
                        <input type="email" name="email" required>
                    </div>
                    <div>
                        <label class="text-gray text-sm">Nomor Telepon</label>
                        <input type="text" name="phone" required>
                    </div>
                    <div>
                        <label class="text-gray text-sm">Alamat Lengkap</label>
                        <textarea name="address" required></textarea>
                    </div>
                    <input type="hidden" name="cartData" value="{{ json_encode($cartData) }}">
                </div>
            </form>
        </div>

        <!-- Ringkasan Pesanan -->
        <div class="bg-gray-800 p-6 shadow-md rounded-lg">
            <h3 class="text-lg font-semibold mb-4 text-white">Ringkasan Pesanan</h3>
            <div class="space-y-4">
                @php $total = 0; @endphp
                @foreach ($cartData as $item)
                    @php
                        $price    = floatval(preg_replace('/[^\d]/', '', $item['price']));
                        $quantity = intval($item['quantity']);
                        $itemTotal = $price * $quantity;
                        $total += $itemTotal;
                    @endphp
                    <div class="flex justify-between border-b pb-2">
                        <div>
                            <p class="text-white font-semibold">{{ $item['name'] }}</p>
                            <p class="text-gray text-sm">
                                {{ $quantity }}x Rp {{ number_format($price, 0, ',', '.') }}
                            </p>
                        </div>
                        <p class="text-white">Rp {{ number_format($itemTotal, 0, ',', '.') }}</p>
                    </div>
                @endforeach
            </div>
            <div class="flex justify-between mt-4 text-lg font-bold text-white">
                <span>Total:</span>
                <span>Rp {{ number_format($total, 0, ',', '.') }}</span>
            </div>
            <button type="submit" form="checkoutForm" class="btn btn-green" id="confirmOrder">
                Konfirmasi Pesanan
            </button>            <a href="{{ route('etalase') }}" class="btn btn-orange">Kembali ke Etalase</a>
        </div>
    </div>
</div>

<!-- Modal Sukses -->
<div id="successModal" class="modal">
    <div class="modal-content">
        <h2>Pesanan Berhasil Dibuat</h2>
       
     
        <a href="{{ route('home') }}" class="btn btn-orange">Kembali ke Home</a>
    </div>
</div>


<script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>
<script>


document.addEventListener("DOMContentLoaded", function () {
    let confirmButton = document.getElementById("confirmOrder");
    let modal = document.getElementById("successModal");

    confirmButton.addEventListener("click", function (e) {
        e.preventDefault(); // Mencegah form dikirim langsung

        modal.style.display = "flex"; // Tampilkan modal sukses

        setTimeout(function () {
            window.location.href = "{{ route('home') }}"; // Redirect ke home setelah 3 detik
        }, 5000);
    });

    let scene, camera, renderer, stars, starGeo;

    function init() {
        scene = new THREE.Scene();
        scene.background = new THREE.Color(0x000000);

        camera = new THREE.PerspectiveCamera(75, window.innerWidth / window.innerHeight, 1, 1000);
        camera.position.z = 200;

        renderer = new THREE.WebGLRenderer({ canvas: document.getElementById("starsCanvas"), alpha: true });
        renderer.setSize(window.innerWidth, window.innerHeight);

        starGeo = new THREE.BufferGeometry();
        let vertices = [];

        for (let i = 0; i < 2000; i++) {
            let x = (Math.random() - 0.5) * 1000;
            let y = (Math.random() - 0.5) * 1000;
            let z = (Math.random() - 0.5) * 1000;
            vertices.push(x, y, z);
        }

        starGeo.setAttribute('position', new THREE.Float32BufferAttribute(vertices, 3));

        let starMaterial = new THREE.PointsMaterial({
            color: 0xffffff,
            size: 2,
            sizeAttenuation: true
        });

        stars = new THREE.Points(starGeo, starMaterial);
        scene.add(stars);

        console.log("Total Stars:", starGeo.attributes.position.count);
    }

    function animate() {
        requestAnimationFrame(animate);
        stars.rotation.y += 0.0005;
        stars.rotation.x += 0.0002;
        renderer.render(scene, camera);
    }

    function onScroll() {
        let scrollY = window.scrollY;
        stars.position.z = scrollY * -0.5;
    }

    window.addEventListener("resize", () => {
        camera.aspect = window.innerWidth / window.innerHeight;
        camera.updateProjectionMatrix();
        renderer.setSize(window.innerWidth, window.innerHeight);
    });

    window.addEventListener("scroll", onScroll);

    init();
    animate();
});
</script>
@endsection

@php 
$activePage = 'etalase';
@endphp
