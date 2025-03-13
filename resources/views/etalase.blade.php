@extends('layouts.app')

@section('title', 'Etalase')

@section('activePage', 'etalase')



@section('content')

<div x-data="catalogApp()" class="min-h-screen">

  <div class="p-4">
      <button @click="sidebarOpen = !sidebarOpen" class="bg-blue-500 text-white p-2 rounded focus:outline-none">
          <template x-if="sidebarOpen">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
              </svg>
          </template>
          <template x-if="!sidebarOpen">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
              </svg>
          </template>
      </button>
  </div>
  
  <div class="flex flex-col md:flex-row">
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
  

    
    <main :class="sidebarOpen ? 'md:w-3/4' : 'md:w-full'" class="transition-all duration-300 p-4">
        <h2 class="text-xl text-white font-bold mb-4" x-text="'Produk ' + activeCategory"></h2>
        <div class="mb-4 w-40">
          <input type="text" placeholder="Search products..." x-model="searchQuery" class="w-full p-2 rounded border border-gray-600 bg-gray-700 text-white" />
      </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            <template x-for="product in filteredProducts" :key="product.id">
                <div class="bg-gray-800 rounded shadow p-4 relative">
                    <img :src="product.image" alt="" class="w-full h-70 object-cover rounded cursor-pointer" @click="openDetail(product)">
                    
                    <h3 class="mt-2 text-lg lg:text-xl font-bold text-white" x-text="product.name"></h3>
                    
                    <p class="mt-1 text-lg text-gray-300" x-text="product.price"></p>
                    
                    <button @click="addToCart(product, $event)"   class="mt-2 bg-blue-500 hover:bg-blue-600 text-white py-1 px-3 rounded transition-all duration-300 transform hover:scale-105 hover:shadow-lg active:scale-95">
                        Add to Cart
                    </button>
                </div>
            </template>
        </div>
    </main>
    
      
  </div>




<div x-show="detailModal" x-transition.opacity.scale.75 class="fixed inset-0 flex items-center justify-center z-50 backdrop-blur-sm bg-opacity-50">
  <div @click.away="detailModal = false" 
       class="bg-gray-800 p-6 rounded-2xl shadow-2xl max-w-md w-full max-h-[90vh] overflow-y-auto relative transform transition-all duration-300 ease-out scale-95">
    
    <button @click="detailModal = false" class="absolute top-3 right-3 text-gray-500 hover:text-red-500 text-2xl transition duration-200">
      &times;
    </button>
    
    <div class="relative w-full h-60 rounded-lg overflow-hidden shadow-md">
      <img :src="selectedProduct.image" alt="" class="w-full h-full object-cover transition duration-300 hover:scale-105">
    </div>

    <div class="mt-4">
      <h2 class="font-extrabold text-xl text-gray-300" x-text="selectedProduct.name"></h2>
      <p class="mt-2 text-gray-400 text-sm leading-relaxed" x-text="selectedProduct.description"></p>
      <p class="mt-3 font-semibold text-lg text-white" x-text="selectedProduct.price"></p>
    </div>

    <button @click="addToCart(selectedProduct)" 
            class="mt-6 bg-blue-500 hover:bg-blue-600 text-white py-3 px-6 rounded-lg w-full font-semibold shadow-lg transition-all duration-300 ease-in-out transform hover:-translate-y-1">
      + Tambah ke Keranjang
    </button>
  </div>
</div>

  

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

    <div x-show="cartOpen" x-cloak x-transition class="absolute bottom-full mb-2 right-0 w-64 bg-white rounded shadow-lg p-4">
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
    body {
        background-color: #111; 
    }

 
    .bg-blue-500 {
        background-color: #ff5722 !important; 
    }

    @media (max-width: 768px) {
        aside {
            background-color: rgba(0, 0, 0, 0.8);
        }
    }

    .text-gray-300 {
        color: #ddd !important;
    }

    @keyframes shake {
    0%, 100% { transform: translateX(0); }
    25% { transform: translateX(-5px); }
    50% { transform: translateX(5px); }
    75% { transform: translateX(-5px); }
}

.shake {
    animation: shake 0.3s ease-in-out;
}
    
</style>


<script>
function catalogApp() {
  return {
    sidebarOpen: true,
    
    categories: ['Rolex', 'Vacheron', 'Omega','Patek Philippe'],
    activeCategory: 'Rolex',
    searchQuery: '',

    
    products: [
      {
        id: 1,
        name: 'Rolex Daytona',
        price: 'Rp 750.000.000',
        image: 'https://media.rolex.com/image/upload/q_auto:eco/f_auto/t_v7-majesty/c_limit,w_3840/v1/catalogue/2024/upright-c/m126500ln-0001',
        description: 'The Rolex Daytona is an iconic chronograph watch known for its high precision and timeless design.',
        category: 'Rolex'
      },
      {
    id: 2,
    name: 'Rolex Submariner Date',
    price: 'Rp 10,250,000',
    image: 'https://media.rolex.com/image/upload/q_auto:eco/f_auto/t_v7-majesty/c_limit,w_3840/v1/catalogue/2024/upright-c/m126610ln-0001',
    description: 'The Rolex Submariner is renowned for its robustness and association with diving, featuring a sleek design and exceptional functionality.',
    category: 'Rolex'
  },

  {
    id: 3,
    name: 'Rolex GMT-Master II',
    price: 'Rp 14,000,000',
    image: 'https://media.rolex.com/image/upload/q_auto:eco/f_auto/t_v7-majesty/c_limit,w_3840/v1/catalogue/2024/upright-c/m126333-0010',
    description: 'The Rolex GMT-Master II is designed for international pilots and travelers, offering the ability to display multiple time zones.',
    category: 'Rolex'
  },
  {
    id: 4,
    name: 'Rolex Datejust 41',
    price: 'Rp 12,000,000',
    image: 'https://media.rolex.com/image/upload/q_auto:eco/f_auto/t_v7-majesty/c_limit,w_3840/v1/catalogue/2024/upright-c/m126333-0010',
    description: 'The Rolex Datejust 41 is a classic timepiece that combines elegance with precision, featuring a sleek design and date function.',
    category: 'Rolex'
  },
  {
    id: 5,
    name: 'Rolex Oyster Perpetual',
    price: 'Rp 20,000,000',
    image: 'https://media.rolex.com/image/upload/q_auto:eco/f_auto/t_v7-majesty/c_limit,w_3840/v1/catalogue/2024/upright-c/m124300-0003',
    description: 'The Rolex Yacht-Master is a luxury watch designed for sailing enthusiasts, combining functionality with sophisticated style.',
    category: 'Rolex'
  },

  {
    id: 6,
    name: 'Vacheron Constantin Overseas',
    price: 'Rp 300,000,000',
    image: 'https://img.chrono24.com/images/uhren/38371063-ijpz9il29eqg0u7ea7d1gfeu-ExtraLarge.jpg',
    description: 'The Vacheron Constantin Overseas is a high-end sports watch known for its robustness and elegance, featuring a sleek design and exceptional functionality.',
    category: 'Vacheron'
  },
  {
    id: 7,
    name: 'Vacheron Constantin Patrimony',
    price: 'Rp 350,000,000',
    image: 'https://img.chrono24.com/images/uhren/36271668-kjhvbjmkylf1g0zrt64uiefq-ExtraLarge.jpg',
    description: 'The Vacheron Constantin Patrimony is renowned for its simple and elegant design, featuring an ultra-thin case inspired by the company\'s 1950s models.',
    category: 'Vacheron'
  },
  {
    id: 8,
    name: 'Vacheron Constantin Métiers d\'Art',
    price: 'Rp 500,000,000',
    image: 'https://www.vacheron-constantin.com/dam/ric-import/vac/abcf/5198/2191395.jpeg.transform.vacrect.jpg',
    description: 'The Vacheron Constantin Métiers d\'Art collection showcases intricate craftsmanship, featuring miniature reproductions of primitive art masks and designs inspired by M.C. Escher.',
    category: 'Vacheron'
  },
  {
    id: 9,
    name: 'Vacheron Constantin Historiques American 1921',
    price: 'Rp 400,000,000',
    image: 'https://img.chrono24.com/images/uhren/38140648-si084iwhu2s3xbxfmz9uc9at-ExtraLarge.jpg',
    description: 'The Vacheron Constantin Historiques American 1921 is a vintage-inspired watch featuring a unique diagonal dial and crown at the 1 o\'clock position, reflecting the bold designs of the Roaring Twenties.',
    category: 'Vacheron'
  },
  {
    id: 10,
    name: 'Vacheron Constantin Traditionnelle',
    price: 'Rp 320,000,000',
    image: 'https://img.chrono24.com/images/uhren/37546861-a01a7oavxgham7ejfw4xb99z-ExtraLarge.jpg',
    description: 'The Vacheron Constantin Traditionnelle is a classic timepiece that combines traditional watchmaking techniques with modern aesthetics, featuring a sleek design and precise movement.',
    category: 'Vacheron'
  },

  {
    id: 11,
    name: 'Omega Speedmaster Moonwatch',
    price: 'Rp 150.000.000',
    image: 'https://flecto.id/_next/image?url=https%3A%2F%2Fflecto.id%2Fpublic%2Fproducts%2F54%2F5154%2Fimg_9123.ycvdFI.1722586022.jpeg&w=1200&q=75',
    description: 'The Omega Speedmaster Moonwatch is an iconic timepiece that was worn on the moon. Its precise chronograph and classic design make it a legendary watch.',
    category: 'Omega'
  },
  {
    id: 12,
    name: 'Omega Seamaster Diver 300M',
    price: 'Rp 100.000.000',
    image: 'https://www.omegawatches.com/media/catalog/product/o/m/omega-seamaster-diver-300m-co-axial-master-chronometer-42-mm-21030422003001-5c4934.png?w=2000',
    description: 'The Omega Seamaster Diver 300M is a professional-grade diving watch with a helium escape valve and a ceramic bezel, designed for adventure under the sea.',
    category: 'Omega'
  },
  {
    id: 13,
    name: 'Omega Constellation Co-Axial',
    price: 'Rp 120.000.000',
    image: 'https://img.chrono24.com/images/uhren/36542965-1kh7115uu3zddy1tj7oj27t9-ExtraLarge.jpg',
    description: 'The Omega Constellation is a luxury dress watch known for its signature claws and half-moon facets, combining elegance with superior watchmaking technology.',
    category: 'Omega'
  },
  {
    id: 14,
    name: 'Omega De Ville Prestige',
    price: 'Rp 90.000.000',
    image: 'https://images-cdn.ubuy.co.id/654200d9c4a38a4dfa564ecd-omega-deville-prestige-co-axial-mens.jpg',
    description: 'The Omega De Ville Prestige is a sophisticated and timeless watch that embodies elegance with its classic design and exceptional craftsmanship.',
    category: 'Omega'
  },
  {
    id: 15,
    name: 'Omega Railmaster',
    price: 'Rp 80.000.000',
    image: 'https://images.tokopedia.net/img/cache/700/VqbcmM/2022/3/21/ede1a8ec-d94d-4702-8c38-1476f0421791.png',
    description: 'The Omega Railmaster is a stylish yet functional watch designed for anti-magnetic resistance, making it a perfect choice for professionals working around strong magnetic fields.',
    category: 'Omega'
  },
  {
    id: 16,
    name: 'Patek Philippe Nautilus',
    price: 'Rp 1.200.000.000',
    image: 'https://omniluxe.id/cdn/shop/files/Patek-Philippe-Nautilus-5711-1R-_1_d0ba3623-9f41-4540-8aa3-ff0549cb3347_1800x.jpg?v=1736928207',
    description: 'The Patek Philippe Nautilus is an iconic luxury sports watch with an elegant yet sporty design, featuring a distinctive porthole-shaped case.',
    category: 'Patek Philippe'
  },
  {
    id: 17,
    name: 'Patek Philippe Aquanaut',
    price: 'Rp 950.000.000',
    image: 'https://images-cdn.ubuy.co.id/636a523526fbee5de3249992-patek-philippe-aquanaut-automatic-black.jpg',
    description: 'The Patek Philippe Aquanaut is a modern and youthful timepiece, featuring a rounded octagonal case and a tropical strap made from composite material.',
    category: 'Patek Philippe'
  },
  {
    id: 18,
    name: 'Patek Philippe Grand',
    price: 'Rp 10.000.000.000',
    image: 'https://img.chrono24.com/images/uhren/34333873-44h4zs9mq814wl0t39a4m82o-ExtraLarge.jpg',
    description: 'The Patek Philippe Grand Complications represents the pinnacle of watchmaking artistry, featuring perpetual calendar, minute repeater, and celestial displays.',
    category: 'Patek Philippe'
  },
  {
    id: 19,
    name: 'Patek Philippe Calatrava',
    price: 'Rp 850.000.000',
    image: 'https://images-cdn.ubuy.co.id/65e0f37b66a22211112baef8-patek-philippe-calatrava-5120j-18k.jpg',
    description: 'The Patek Philippe Calatrava is a symbol of timeless elegance, embodying pure lines and classic design that has defined dress watches for decades.',
    category: 'Patek Philippe'
  },
  {
    id: 20,
    name: 'Patek Philippe Annual',
    price: 'Rp 1.500.000.000',
    image: 'https://idwx.co/cdn/shop/products/PatekCalatrava.jpg?v=1651043106',
    description: 'The Patek Philippe Annual Calendar is a sophisticated watch that automatically adjusts for months with 30 and 31 days, requiring only one manual correction per year.',
    category: 'Patek Philippe'
  }

    ],
    cart: [],
    cartCount: 0,
    cartOpen: false,
    
    detailModal: false,
    selectedProduct: {},
    searchQuery: '',
    
    get filteredProducts() {
      return this.products.filter(product => {
          let matchesCategory = product.category === this.activeCategory;
          let matchesSearch = product.name.toLowerCase().includes(this.searchQuery.toLowerCase());
          return matchesCategory && matchesSearch;
      });
    },
    
    addToCart(product, event = null) {
    let existing = this.cart.find(item => item.id === product.id);
    if (existing) {
        existing.quantity++;
    } else {
        let newItem = Object.assign({}, product);
        newItem.quantity = 1;
        this.cart.push(newItem);
    }
    this.cartCount = this.cart.reduce((acc, item) => acc + item.quantity, 0);
    
    let cartIcon = document.querySelector('.cart-icon');
    cartIcon.classList.add('shake');
    setTimeout(() => {
        cartIcon.classList.remove('shake');
    }, 300); 

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
    
    removeFromCart(index) {
      let item = this.cart[index];
      if (item.quantity > 1) {
        item.quantity--;
      } else {
        this.cart.splice(index, 1);
      }
      this.cartCount = this.cart.reduce((acc, item) => acc + item.quantity, 0);
    },
    
    openDetail(product) {
      this.selectedProduct = product;
      this.detailModal = true;
    },

     checkout() {
  if (this.cartCount === 0) {
    alert("Keranjang masih kosong. Tambahkan barang terlebih dahulu sebelum checkout.");
    return;
  }
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

  