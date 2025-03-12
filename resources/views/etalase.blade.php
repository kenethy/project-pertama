@extends('layouts.app')

@section('title', 'Etalase')

@section('activePage', 'etalase')



@section('content')

<div x-data="catalogApp()" class="min-h-screen">

  <!-- Tombol Toggle Sidebar untuk Mobile -->
  <div class="p-4">
      <button @click="sidebarOpen = !sidebarOpen" class="bg-blue-500 text-white p-2 rounded focus:outline-none">
          <template x-if="sidebarOpen">
              <!-- Close Icon -->
              <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
              </svg>
          </template>
          <template x-if="!sidebarOpen">
              <!-- Hamburger Menu Icon -->
              <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
              </svg>
          </template>
      </button>
  </div>
  
  <!-- Layout dengan Sidebar & Grid -->
  <div class="flex flex-col md:flex-row">
    <!-- Sidebar Kategori (dapat ditutup dan dibuka) -->
    <aside x-show="sidebarOpen" 
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0 transform -translate-x-full"
    x-transition:enter-end="opacity-100 transform translate-x-0"
    x-transition:leave="transition ease-in duration-300"
    x-transition:leave-start="opacity-100 transform translate-x-0"
    x-transition:leave-end="opacity-0 transform -translate-x-full"
    class="md:w-1/4 p-4 border-b md:border-b-0 md:border-r border-gray-200">
    <h2 class="text-xl text-white font-bold mb-4">Kategori</h2>
    <ul>
      <template x-for="category in categories" :key="category">
        <li class="mb-2">
          <button @click="activeCategory = category" 
                  :class="{'bg-blue-500 text-white': activeCategory === category, 'text-white hover:bg-gray-700': activeCategory !== category}"
                  class="w-full text-left px-3 py-2 rounded transition-colors duration-200">
            <span x-text="category"></span>
          </button>
        </li>
      </template>
    </ul>
  </aside>
  

    <!-- Grid Produk -->
    <main :class="sidebarOpen ? 'md:w-3/4' : 'md:w-full'" class="transition-all duration-300 p-4">
        <h2 class="text-xl text-white font-bold mb-4" x-text="'Produk ' + activeCategory"></h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            <template x-for="product in filteredProducts" :key="product.id">
                <div class="bg-gray-800 rounded shadow p-4 relative">
                    <!-- Gambar Produk: klik untuk detail -->
                    <img :src="product.image" alt="" class="w-full h-70 object-cover rounded cursor-pointer" @click="openDetail(product)">
                    
                    <!-- Nama Produk -->
                    <h3 class="mt-2 text-lg lg:text-xl font-bold text-white" x-text="product.name"></h3>
                    
                    <!-- Harga Produk -->
                    <p class="mt-1 text-lg text-gray-300" x-text="product.price"></p>
                    
                    <!-- Tombol Add to Cart -->
                    <button @click="addToCart(product, $event)"   class="mt-2 bg-blue-500 hover:bg-blue-600 text-white py-1 px-3 rounded transition-all duration-300 transform hover:scale-105 hover:shadow-lg active:scale-95">
                        Add to Cart
                    </button>
                </div>
            </template>
        </div>
    </main>
    
      
  </div>




  <!-- Modal Pop-Up Detail Produk -->
<div x-show="detailModal" x-transition.opacity.scale.75 class="fixed inset-0 flex items-center justify-center z-50 backdrop-blur-sm bg-opacity-50">
  <div @click.away="detailModal = false" class="bg-gray-800 p-6 rounded-2xl shadow-2xl max-w-md w-full relative transform transition-all duration-300 ease-out scale-95">
    
    <!-- Tombol Close -->
    <button @click="detailModal = false" class="absolute top-3 right-3 text-gray-500 hover:text-red-500 text-2xl transition duration-200">
      &times;
    </button>
    
    <!-- Gambar Produk -->
    <div class="relative w-full h-full rounded-lg overflow-hidden shadow-md">
      <img :src="selectedProduct.image" alt="" class="w-full h-full object-cover transition duration-300 hover:scale-105">
    </div>

    <!-- Informasi Produk -->
    <div class="mt-4">
      <h2 class="font-extrabold text-xl text-gray-800" x-text="selectedProduct.name"></h2>
      <p class="mt-2 text-gray-600 text-sm leading-relaxed" x-text="selectedProduct.description"></p>
      <p class="mt-3 font-semibold text-lg text-white" x-text="(selectedProduct.price)"></p>
    </div>

    <!-- Tombol Add to Cart -->
    <button @click="addToCart(selectedProduct)" class="mt-6 bg-blue-500 hover:bg-blue-600 text-white py-3 px-6 rounded-lg w-full font-semibold shadow-lg transition-all duration-300 ease-in-out transform hover:-translate-y-1">
      + Tambah ke Keranjang
    </button>
  </div>
</div>

  

  <!-- Floating Cart Icon dengan Toggle Popup via Click -->
  <div class="fixed bottom-4 right-4 z-50 cart-icon">
    <button @click="cartOpen = !cartOpen" class="relative bg-blue-500 hover:bg-blue-600 text-white p-3 rounded-full shadow-lg focus:outline-none">
      <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13l-1.2 6m1.2-6h10m-10 0L5 5m10 8l1.2 6m-1.2-6H5.4"/>
      </svg>
      <span x-show="cartCount > 0" 
            class="absolute top-0 right-0 inline-block w-5 h-5 bg-red-600 text-white text-xs font-bold rounded-full text-center"
            x-text="cartCount"></span>
    </button>

    <!-- Popup Cart: tampil di atas ikon saat cartOpen true -->
    <div x-show="cartOpen" x-transition class="absolute bottom-full mb-2 right-0 w-64 bg-white rounded shadow-lg p-4">
      <template x-if="cart.length === 0">
        <p class="text-gray-600 text-sm">Keranjang masih kosong.</p>
      </template>
      <template x-for="(item, index) in cart" :key="item.id">
        <div class="flex items-center justify-between border-b py-1">
          <div>
            <p class="font-semibold text-gray-800 text-sm">
              <span x-text="item.quantity"></span>x <span x-text="item.name"></span>
            </p>
            <p class="text-gray-600 text-xs" x-text="item.price"></p>
          </div>
          <button @click="removeFromCart(index)" class="text-red-500 text-xs">Hapus</button>
        </div>
      </template>
      <!-- Form Checkout: data cart akan dikirim ke route 'checkout' -->
      <form id="checkoutForm" action="{{ route('checkout') }}" method="POST" x-ref="checkoutForm" class="mt-4">
        @csrf
        <input type="hidden" name="cartData" x-ref="cartData">
        <button style="background-color: #ff5722" type="button" @click="checkout()" class="w-full bg-green-500 hover:bg-green-600 text-white py-2 px-4 rounded">
          Checkout
        </button>
      </form>
    </div>
  </div>
  
  
  
  
  

 
</div>

<style>
    /* Override warna latar belakang */
    body {
        background-color: #111; /* Ganti dengan warna yang diinginkan */
    }

    /* Override warna tombol */
    .bg-blue-500 {
        background-color: #ff5722 !important; /* Ganti warna tombol */
    }

    /* Override sidebar agar tidak terlihat saat mobile */
    @media (max-width: 768px) {
        aside {
            background-color: rgba(0, 0, 0, 0.8); /* Contoh mengubah warna sidebar */
        }
    }

    /* Sesuaikan warna teks produk */
    .text-gray-300 {
        color: #ddd !important;
    }

    @keyframes shake {
    0%, 100% { transform: translateX(0); }
    25% { transform: translateX(-5px); }
    50% { transform: translateX(5px); }
    75% { transform: translateX(-5px); }
}

/* Tambahkan class ini ke elemen yang ingin digoyangkan */
.shake {
    animation: shake 0.3s ease-in-out;
}
    
</style>


<!-- Script Alpine.js untuk logika katalog -->
<script>
function catalogApp() {
  return {
    // Sidebar toggle state
    sidebarOpen: true,
    // List kategori
    categories: ['Elektronik', 'Fashion', 'Gadget', 'Home Appliance'],
    activeCategory: 'Elektronik',
    
    // Data produk statis (masing-masing produk memiliki properti kategori)
    products: [
      { id: 1, name: 'Smartphone XYZ', price: 'Rp 3.000.000', image: 'images/jam1.png', description: 'Smartphone XYZ dengan fitur canggih.', category: 'Elektronik' },
      { id: 2, name: 'Laptop ABC', price: 'Rp 7.000.000', image: 'https://via.placeholder.com/300x200', description: 'Laptop ABC untuk produktivitas tinggi.', category: 'Elektronik' },
      { id: 3, name: 'Sneakers Trendy', price: 'Rp 500.000', image: 'https://via.placeholder.com/300x200', description: 'Sneakers Trendy nyaman dipakai sehari-hari.', category: 'Fashion' },
      { id: 4, name: 'Smartwatch Z', price: 'Rp 1.200.000', image: 'https://via.placeholder.com/300x200', description: 'Smartwatch Z untuk gaya hidup modern.', category: 'Gadget' },
      { id: 5, name: 'Refrigerator X', price: 'Rp 3.500.000', image: 'https://via.placeholder.com/300x200', description: 'Refrigerator X dengan kapasitas besar.', category: 'Home Appliance' },
      { id: 6, name: 'T-Shirt Casual', price: 'Rp 150.000', image: 'https://via.placeholder.com/300x200', description: 'T-Shirt Casual yang nyaman dan stylish.', category: 'Fashion' },
    ],
    
    // Data keranjang: sekarang menyimpan item sebagai objek dengan properti 'quantity'
    cart: [],
    cartCount: 0,
    cartOpen: false,
    
    // Modal detail produk
    detailModal: false,
    selectedProduct: {},
    
    // Filter produk berdasarkan kategori aktif
    get filteredProducts() {
      return this.products.filter(product => product.category === this.activeCategory);
    },
    
    // Method untuk menambahkan produk ke keranjang dengan penggabungan produk yang sama
    addToCart(product, event = null) {
    let existing = this.cart.find(item => item.id === product.id);
    if (existing) {
        existing.quantity++;
    } else {
        let newItem = Object.assign({}, product);
        newItem.quantity = 1;
        this.cart.push(newItem);
    }
    // Hitung total jumlah item dalam keranjang
    this.cartCount = this.cart.reduce((acc, item) => acc + item.quantity, 0);
    
    // 🔹 Tambahkan efek goyang pada ikon keranjang
    let cartIcon = document.querySelector('.cart-icon');
    cartIcon.classList.add('shake');
    setTimeout(() => {
        cartIcon.classList.remove('shake');
    }, 300); // Hapus class setelah animasi selesai (0.3 detik)

    // 🔹 Animasi produk terbang ke keranjang
    if (event) {
        let productContainer = event.target.closest('div');
        let imageEl = productContainer.querySelector('img');
        if (imageEl) {
            let clone = imageEl.cloneNode(true);
            let rect = imageEl.getBoundingClientRect();
            clone.style.position = 'fixed';
            clone.style.top = rect.top + 'px';
            clone.style.left = rect.left + 'px';
            clone.style.width = rect.width + 'px';
            clone.style.height = rect.height + 'px';
            clone.style.zIndex = '1000';
            clone.style.transition = 'transform 1s ease-in-out, opacity 1s ease-in-out';
            document.body.appendChild(clone);
            
            let cartRect = cartIcon.getBoundingClientRect();
            let translateX = (cartRect.left + cartRect.width / 2) - (rect.left + rect.width / 2);
            let translateY = (cartRect.top + cartRect.height / 2) - (rect.top + rect.height / 2);
            
            setTimeout(() => {
                clone.style.transform = `translate(${translateX}px, ${translateY}px) scale(0.2)`;
                clone.style.opacity = '0';
            }, 50);
            
            setTimeout(() => {
                clone.remove();
            }, 1050);
        }
    }
},
    
    // Method untuk menghapus produk dari keranjang: jika quantity > 1, dikurangi satu; jika sama dengan 1, hapus item tersebut
    removeFromCart(index) {
      let item = this.cart[index];
      if (item.quantity > 1) {
        item.quantity--;
      } else {
        this.cart.splice(index, 1);
      }
      this.cartCount = this.cart.reduce((acc, item) => acc + item.quantity, 0);
    },
    
    // Method untuk membuka modal detail produk
    openDetail(product) {
      this.selectedProduct = product;
      this.detailModal = true;
    },

     // Method Checkout: kirim data cart ke blade checkout
     checkout() {
      let data = JSON.stringify(this.cart);
      this.$refs.cartData.value = data;
      this.$refs.checkoutForm.submit();
    }
  }

}


</script>
@endsection
@php 
$activePage = 'etalase';
@endphp

  