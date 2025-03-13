@extends('layouts.app')

@section('title', 'Home')

@section('content')
<!-- Impor Font Rock Salt -->
<link rel="preconnect" href="https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=Rock+Salt&display=swap" rel="stylesheet">

<!-- Custom Style -->
<style>

@media (max-width: 768px) {
    #logo {
        width: 70%; /* Lebih besar */
        max-width: 250px; /* Maksimum diperbesar */
    }

    #brandName {
        font-size: 2.5rem; /* Diperbesar */
    }

    #tagline {
        font-size: 1.4rem; /* Diperbesar */
    }

    .heading-aesthetic {
        font-size: 2.2rem; /* Diperbesar */
    }

    #productDisplay {
        width: 100%;
        max-width: 400px; 
    }

    #productInfo {
        font-size: 1.2rem; 
        padding: 15px; 
    }

    #prevBtn, #nextBtn {
        font-size: 2rem; 
        padding: 12px;
    }

    .content-wrapper {
        padding: 30px 0; 
    }

    #bestSellerText {
        margin-bottom: 20px;
    }

    .relative.py-16 {
        padding-bottom: 30px; 
    }

    footer {
        margin-top: -20px; 
    }
}



  .heading-aesthetic {
    font-family: '', ;
    font-size: 2rem;
    color: white;
    
    transform: scale(0.8);
    position: relative;
    z-index: 10;
  }


  #starsCanvas {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100vh;
    z-index: 0;
    pointer-events: none;
  }


  .content-wrapper {
  position: relative;
  z-index: 5;
 
  padding: 50px 0;
}

#logo {
    opacity: 0;
    filter: blur(10px); 
    transform: scale(0.9);
}


#prevBtn, #nextBtn {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    background-color: rgba(0, 0, 0, 0.5);
    color: white;
    padding: 10px;
    border-radius: 50%;
    cursor: pointer;
    transition: background 0.3s, transform 0.2s;
}

#prevBtn:hover, #nextBtn:hover {
    background-color: rgba(0, 0, 0, 0.8);
    transform: translateY(-50%) scale(1.1);
}

#prevBtn {
    left: 10px;
}

#nextBtn {
    right: 10px;
}

/* Responsif untuk HP */
@media (max-width: 768px) {
    #prevBtn, #nextBtn {
        padding: 8px;
        font-size: 1.2rem;
    }
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

        <a href="{{route('etalase')}}" id="catalogButton" class="mt-6 inline-block bg-[#d45630] text-white px-6 py-3 rounded-lg font-semibold text-lg 
   transition-transform transform hover:scale-105 hover:bg-[#b64529] opacity-0">
Katalog
</a>
    </div>
</section>

<section class="relative py-16 text-center content-wrapper">
    <div class="container mx-auto px-4">
        <h2 class="heading-aesthetic font-bold mb-8" id="bestSellerText" style="color: #d45630;">OUR BEST SELLER</h2>
        <div class="relative flex justify-center items-center">
            <button id="prevBtn" class="absolute left-100 text-white bg-black bg-opacity-50 p-3 rounded-full 
    hover:bg-opacity-70 hover:scale-110 hover:bg-gray-800 transition duration-300 ease-in-out">
    ❮
</button>

            <div id="productDisplay" class="relative  w-3/4 max-w-sm flex items-center justify-center overflow-hidden">
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
    $noFooter= true;
@endphp
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>

<script>
document.addEventListener("DOMContentLoaded", function () {
    const products = [
        { image: "{{ asset('images/jam2.png') }}", title: "Jacob & Co. Godfather Watch"},
        { image: "{{ asset('images/jam1.png') }}", title: "AMD RTX 950 TI" },
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

    updateProduct(); 
    gsap.to("#catalogButton", { 
    opacity: 1, 
    y: 0, 
    duration: 1, 
    ease: "power2.out", 
    delay: 1.2 
});


    gsap.to("#bestSellerText", {
        opacity: 1,
        scale: 1.4,
        duration: 4,
        ease: "power2.out"
    });

    gsap.timeline()
        .to("#logo", { 
            opacity: 1, 
            filter: "blur(0px)", 

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