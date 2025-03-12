@extends('layouts.app')

@section('title', 'Home')

@section('content')
<!-- Impor Font Rock Salt -->
<link rel="preconnect" href="https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=Rock+Salt&display=swap" rel="stylesheet">

<!-- Custom Style -->
<style>
  /* Animasi Best Seller */
  .heading-aesthetic {
    font-family: '', ;
    font-size: 2rem;
    color: white;
    
    transform: scale(0.8);
    position: relative;
    z-index: 10;
  }

  /* Canvas untuk bintang */
  #starsCanvas {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100vh;
    z-index: 0;
    pointer-events: none;
  }

  /* Wrapper untuk kontras */
  .content-wrapper {
  position: relative;
  z-index: 5;
 
  padding: 50px 0;
}

#logo {
    opacity: 0;
    filter: blur(10px); /* Tambahkan efek blur awal */
    transform: scale(0.9);
}





  /* Animasi Fade */
  .fade {
    opacity: 0;
    transform: scale(0.95);
    transition: opacity 0.5s ease, transform 0.5s ease;
  }
  .fade.active {
    opacity: 1;
    transform: scale(1);
  }
</style>

<!-- Canvas untuk bintang -->
<canvas id="starsCanvas"></canvas>

<!-- HERO SECTION -->
<section class="py-12 text-white text-center content-wrapper">
    <div class="container mx-auto px-4">
        <!-- Logo & Nama Brand -->
        <img id="logo" src="images/yonopedia.png" alt="Yonowatch Logo" class="mx-auto mb-4 w-40 opacity-0 blur-md"> 
        
        <h1 id="brandName" class="text-5xl font-bold tracking-wide opacity-0 scale-75" style="font-family: 'Montserrat', sans-serif;">
            YONOWATCH
        </h1>
        
        <p id="tagline" class="mt-2 text-lg text-gray-300 italic opacity-0 translate-y-10">
            Your Only Watch Retailer
        </p>
    </div>
</section>


<!-- BEST SELLER PRODUCT SECTION -->
<section class="relative py-16 text-center content-wrapper">
    <div class="container mx-auto px-4">
        <!-- Animasi Heading -->
        <h2 class="heading-aesthetic font-bold mb-8" id="bestSellerText" style="color: #d45630;">OUR BEST SELLER</h2>

        <!-- Produk Slider -->
        <div class="relative flex justify-center items-center">
            <button id="prevBtn" class="absolute left-100 text-white bg-black bg-opacity-50 p-3 rounded-full 
    hover:bg-opacity-70 hover:scale-110 hover:bg-gray-800 transition duration-300 ease-in-out">
    ❮
</button>

            <div id="productDisplay" class="relative w-3/4 max-w-2xl h-96 flex items-center justify-center overflow-hidden">
                <img id="productImage" class="w-full max-h-full object-contain fade active">
                <div id="productInfo" class="absolute bottom-2 bg-black bg-opacity-50 px-6 py-3 rounded-lg">
                    <h3 class="text-2xl font-semibold text-white" id="productTitle" style="color: #ff5722;"></h3>
                    <p class="text-lg text-gray-300" id="productDesc"></p>
                    <span class="text-xl font-bold text-yellow-400" id="productPrice"></span>
                </div>
            </div>
            
            

            <button id="nextBtn" class="absolute right-100 text-white bg-black bg-opacity-50 p-3 rounded-full 
    hover:bg-opacity-70 hover:scale-110 hover:bg-gray-800 transition duration-300 ease-in-out">
    ❯
</button>
        </div>
    </div>
</section>

@endsection

@php
    $activePage = 'home';
@endphp

<!-- GSAP + Three.js -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>

<script>
document.addEventListener("DOMContentLoaded", function () {
    /** DATA PRODUK **/
    const products = [
        { image: "{{ asset('images/jam2.png') }}", title: "Produk 1", desc: "", price: "" },
        { image: "{{ asset('images/jam1.png') }}", title: "Produk 2", desc: "", price: "" },
        { image: "{{ asset('images/jam3.png') }}", title: "Produk 3", desc: "", price: "" }
    ];

    let currentIndex = 0;
    const productImage = document.getElementById("productImage");
    const productTitle = document.getElementById("productTitle");
    const productDesc = document.getElementById("productDesc");
    const productPrice = document.getElementById("productPrice");
    
    function updateProduct() {
        productImage.classList.remove("active"); // Hapus efek aktif
        setTimeout(() => {
            productImage.src = products[currentIndex].image;
            productTitle.innerText = products[currentIndex].title;
            productDesc.innerText = products[currentIndex].desc;
            productPrice.innerText = products[currentIndex].price;
            productImage.classList.add("active"); // Tambahkan efek aktif
        }, 400);
    }
    
    document.getElementById("nextBtn").addEventListener("click", () => {
        currentIndex = (currentIndex + 1) % products.length;
        updateProduct();
    });

    document.getElementById("prevBtn").addEventListener("click", () => {
        currentIndex = (currentIndex - 1 + products.length) % products.length;
        updateProduct();
    });

    updateProduct(); // Set produk pertama saat halaman dimuat


    gsap.to("#bestSellerText", {
        opacity: 1,
        scale: 1.4,
        duration: 4,
        ease: "power2.out"
    });

    gsap.timeline()
        .to("#logo", { 
            opacity: 1, 
            filter: "blur(0px)", /* Hapus blur secara bertahap */

            duration: 1.5, 
            ease: "power3.out" 
        })
        .to("#brandName", { 
            opacity: 1, 
            scale: 1, 
            duration: 1.2, 
            ease: "elastic.out(1, 0.5)" 
        }, "-=1")
        .to("#tagline", { 
            opacity: 1, 
            y: 0, 
            duration: 1, 
            ease: "power2.out" 
        }, "-=0.8");
    /** KONFIGURASI THREE.JS BINTANG 3D **/
    let scene, camera, renderer, stars, starGeo;

    function init() {
        scene = new THREE.Scene();
        camera = new THREE.PerspectiveCamera(75, window.innerWidth / window.innerHeight, 1, 1000);
        camera.position.z = 500;

        renderer = new THREE.WebGLRenderer({ canvas: document.getElementById("starsCanvas"), alpha: true });
        renderer.setSize(window.innerWidth, window.innerHeight);
        document.body.appendChild(renderer.domElement);

        starGeo = new THREE.BufferGeometry();
        let vertices = [];

        for (let i = 0; i < 2000; i++) {
            let x = (Math.random() - 0.5) * 2000;
            let y = (Math.random() - 0.5) * 2000;
            let z = (Math.random() - 0.5) * 2000;
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

