@extends('layouts.app')
@section('title', 'Keranjang Belanja')
@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8 lg:py-12">
    <div class="mb-8">
        <h1 class="text-3xl font-extrabold font-['Outfit'] text-gray-900 mb-2 tracking-tight">Keranjang Belanja</h1>
        <p class="text-gray-500">Tinjau kembali pilihan game dan aplikasi yang ingin Anda sewa.</p>
    </div>

    @if($items->count() > 0)
    <div class="space-y-4 mb-8">
        @foreach($items as $item)
        <div class="bg-white border border-gray-200 rounded-3xl p-5 md:p-6 flex flex-col sm:flex-row items-center gap-6 shadow-sm hover:shadow-md transition-shadow relative">
            <div class="absolute top-4 left-4 sm:static">
                <input type="checkbox" name="item_ids[]" value="{{ $item->id }}" class="cart-checkbox w-5 h-5 text-blue-600 border-gray-300 rounded focus:ring-blue-500 cursor-pointer" data-price="{{ $item->produk->harga_sewa * $item->qty }}" checked>
            </div>
            <div class="w-20 h-20 bg-gray-50 border border-gray-100 rounded-2xl flex items-center justify-center shrink-0 shadow-sm overflow-hidden mt-4 sm:mt-0">
                @if($item->produk->gambar)
                <img src="{{ asset('storage/' . $item->produk->gambar) }}" class="w-full h-full object-cover" alt="">
                @else
                <svg class="w-8 h-8 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/></svg>
                @endif
            </div>
            
            <div class="flex-1 text-center sm:text-left">
                <a href="{{ route('katalog.show', $item->produk->id) }}" class="inline-block hover:text-blue-600 transition">
                    <h3 class="font-bold text-gray-900 text-lg mb-1">{{ $item->produk->nama_produk }}</h3>
                </a>
                <p class="text-sm text-gray-500 font-medium">Rp {{ number_format($item->produk->harga_sewa, 0, ',', '.') }}<span class="text-xs">/minggu</span></p>
            </div>

            <div class="flex items-center gap-6 sm:gap-8 bg-gray-50 p-2 sm:p-0 sm:bg-transparent rounded-2xl">
                <form action="/cart/update/{{ $item->id }}" method="POST" class="flex items-center gap-2 bg-white sm:bg-gray-50 p-1 rounded-xl border border-gray-200 sm:border-transparent">
                    @csrf
                    @method('PATCH')
                    <input type="number" name="qty" value="{{ $item->qty }}" min="1" max="{{ $item->produk->stok }}"
                        class="w-14 px-1 py-1.5 bg-transparent text-gray-900 font-semibold text-center text-sm focus:outline-none appearance-none">
                    <button type="submit" class="px-3 py-1.5 bg-gray-200 text-gray-700 font-semibold rounded-lg hover:bg-blue-600 hover:text-white transition text-xs shadow-sm">Ubah</button>
                </form>
                
                <div class="text-right min-w-[100px]">
                    <p class="text-xs text-gray-500 font-medium mb-0.5">Subtotal</p>
                    <p class="font-bold text-gray-900 text-lg">Rp {{ number_format($item->produk->harga_sewa * $item->qty, 0, ',', '.') }}</p>
                </div>
            </div>

            <form action="/cart/remove/{{ $item->id }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="p-2.5 text-gray-400 hover:text-red-500 hover:bg-red-50 rounded-xl transition" title="Hapus dari keranjang">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                </button>
            </form>
        </div>
        @endforeach
    </div>

    <div class="bg-white border border-gray-200 rounded-3xl p-6 sm:p-8 shadow-sm relative overflow-hidden">
        <div class="absolute -right-12 -top-12 w-40 h-40 bg-blue-50 rounded-full blur-3xl"></div>
        <div class="relative z-10 flex flex-col md:flex-row items-center justify-between gap-6">
            <div>
                <p class="text-gray-500 font-medium mb-1">Total Pembayaran</p>
                <p class="text-3xl font-extrabold text-blue-600 tracking-tight" id="total-pembayaran">Rp {{ number_format($total ?? 0, 0, ',', '.') }}</p>
            </div>
            <div class="w-full md:w-auto">
                <form id="checkout-form" action="{{ route('cart.checkoutForm') }}" method="GET">
                    <button type="submit" id="checkout-btn" class="w-full md:w-auto px-8 py-4 bg-blue-600 text-white font-bold rounded-2xl hover:bg-blue-700 transition-all shadow-lg shadow-blue-600/20 active:scale-[0.98] flex items-center justify-center gap-3">
                        Lanjutkan ke Pembayaran
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const checkboxes = document.querySelectorAll('.cart-checkbox');
            const totalEl = document.getElementById('total-pembayaran');
            const checkoutBtn = document.getElementById('checkout-btn');

            function updateTotal() {
                let total = 0;
                let checkedCount = 0;
                checkboxes.forEach(cb => {
                    if (cb.checked) {
                        total += parseInt(cb.dataset.price);
                        checkedCount++;
                    }
                });
                
                // Format rupiah
                totalEl.textContent = 'Rp ' + total.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
                
                // Disable button if nothing checked
                if (checkedCount === 0) {
                    checkoutBtn.disabled = true;
                    checkoutBtn.classList.add('opacity-50', 'cursor-not-allowed');
                } else {
                    checkoutBtn.disabled = false;
                    checkoutBtn.classList.remove('opacity-50', 'cursor-not-allowed');
                }
            }

            checkboxes.forEach(cb => {
                cb.addEventListener('change', updateTotal);
            });

            // Set initial state
            updateTotal();

            // Intercept form submit to add hidden inputs
            document.getElementById('checkout-form').addEventListener('submit', function(e) {
                // Remove any existing hidden inputs first
                this.querySelectorAll('input[name="item_ids[]"]').forEach(input => input.remove());
                
                checkboxes.forEach(cb => {
                    if (cb.checked) {
                        const hiddenInput = document.createElement('input');
                        hiddenInput.type = 'hidden';
                        hiddenInput.name = 'item_ids[]';
                        hiddenInput.value = cb.value;
                        this.appendChild(hiddenInput);
                    }
                });
            });
        });
    </script>
    @else
    <div class="bg-white border border-gray-200 rounded-3xl p-16 text-center shadow-sm max-w-2xl mx-auto">
        <div class="w-24 h-24 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-6">
            <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 100 4 2 2 0 000-4z"/></svg>
        </div>
        <h2 class="text-2xl font-bold text-gray-900 mb-2">Keranjang Anda Kosong</h2>
        <p class="text-gray-500 mb-8">Sepertinya Anda belum memilih aplikasi atau game apapun. Yuk, jelajahi katalog kami!</p>
        <a href="/katalog" class="inline-flex items-center gap-2 px-8 py-3.5 bg-blue-600 text-white font-semibold rounded-2xl hover:bg-blue-700 transition-all shadow-md shadow-blue-600/20 active:scale-95">
            Mulai Belanja
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
        </a>
    </div>
    @endif
</div>
@endsection
