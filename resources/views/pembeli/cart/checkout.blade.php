@extends('layouts.app')
@section('title', 'Checkout Pembayaran')
@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8 lg:py-12">
    <div class="mb-8">
        <h1 class="text-3xl font-extrabold font-['Outfit'] text-gray-900 mb-2 tracking-tight">Checkout Pembayaran</h1>
        <p class="text-gray-500">Selesaikan pembayaran Anda untuk menyewa produk pilihan.</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        {{-- Ringkasan Pesanan --}}
        <div class="lg:col-span-1 order-2 lg:order-1">
            <div class="bg-gray-50 border border-gray-200 rounded-3xl p-6 shadow-sm sticky top-24">
                <h3 class="text-lg font-bold text-gray-900 mb-4">Ringkasan Pesanan</h3>
                <div class="space-y-4 mb-6">
                    @foreach($items as $item)
                    <div class="flex justify-between items-start gap-4">
                        <div>
                            <p class="text-sm font-semibold text-gray-900">{{ $item->produk->nama_produk }}</p>
                            <p class="text-xs text-gray-500">{{ $item->qty }}x item</p>
                        </div>
                        <p class="text-sm font-bold text-gray-900">Rp {{ number_format($item->produk->harga_sewa * $item->qty, 0, ',', '.') }}</p>
                    </div>
                    @endforeach
                </div>
                <div class="pt-4 border-t border-gray-200 flex justify-between items-center">
                    <p class="text-sm font-bold text-gray-500 uppercase tracking-wide">Total Pembayaran</p>
                    <p class="text-xl font-extrabold text-blue-600">Rp {{ number_format($total, 0, ',', '.') }}</p>
                </div>
            </div>
        </div>

        {{-- Form Pembayaran --}}
        <div class="lg:col-span-2 order-1 lg:order-2">
            <div class="bg-white border border-gray-200 rounded-3xl p-6 md:p-8 shadow-sm">
                <form action="{{ route('cart.processCheckout') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    @foreach($items as $item)
                        <input type="hidden" name="item_ids[]" value="{{ $item->id }}">
                    @endforeach
                    
                    {{-- Metode Pembayaran --}}
                    <div class="mb-8">
                        <h3 class="text-lg font-bold text-gray-900 mb-4">Pilih Metode Pembayaran</h3>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <label class="relative cursor-pointer">
                                <input type="radio" name="metode_pembayaran" value="BCA - 1234567890 (A.N Rentopia)" class="peer sr-only" checked>
                                <div class="p-4 rounded-xl border-2 border-gray-200 hover:bg-gray-50 peer-checked:border-blue-500 peer-checked:bg-blue-50 transition-all">
                                    <div class="flex items-center justify-between mb-2">
                                        <p class="font-bold text-gray-900">Bank BCA</p>
                                        <svg class="w-6 h-6 text-blue-500 hidden peer-checked:block" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    </div>
                                    <p class="text-sm text-gray-600 font-mono">1234567890</p>
                                    <p class="text-xs text-gray-500 mt-1">A.N Rentopia Corp</p>
                                </div>
                            </label>
                            
                            <label class="relative cursor-pointer">
                                <input type="radio" name="metode_pembayaran" value="Mandiri - 0987654321 (A.N Rentopia)" class="peer sr-only">
                                <div class="p-4 rounded-xl border-2 border-gray-200 hover:bg-gray-50 peer-checked:border-blue-500 peer-checked:bg-blue-50 transition-all">
                                    <div class="flex items-center justify-between mb-2">
                                        <p class="font-bold text-gray-900">Bank Mandiri</p>
                                        <svg class="w-6 h-6 text-blue-500 hidden peer-checked:block" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    </div>
                                    <p class="text-sm text-gray-600 font-mono">0987654321</p>
                                    <p class="text-xs text-gray-500 mt-1">A.N Rentopia Corp</p>
                                </div>
                            </label>

                            <label class="relative cursor-pointer">
                                <input type="radio" name="metode_pembayaran" value="GoPay - 081234567890" class="peer sr-only">
                                <div class="p-4 rounded-xl border-2 border-gray-200 hover:bg-gray-50 peer-checked:border-blue-500 peer-checked:bg-blue-50 transition-all">
                                    <div class="flex items-center justify-between mb-2">
                                        <p class="font-bold text-gray-900">GoPay / e-Wallet</p>
                                        <svg class="w-6 h-6 text-blue-500 hidden peer-checked:block" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    </div>
                                    <p class="text-sm text-gray-600 font-mono">0812 3456 7890</p>
                                    <p class="text-xs text-gray-500 mt-1">A.N Rentopia</p>
                                </div>
                            </label>
                        </div>
                    </div>

                    {{-- Upload Bukti --}}
                    <div class="mb-8">
                        <h3 class="text-lg font-bold text-gray-900 mb-4">Upload Bukti Transfer</h3>
                        <div class="w-full">
                            <label for="bukti_transfer" class="block w-full px-4 py-8 border-2 border-dashed border-gray-300 rounded-2xl text-center cursor-pointer hover:bg-gray-50 hover:border-blue-500 transition-colors">
                                <svg class="w-8 h-8 text-gray-400 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                                <span class="text-sm font-medium text-gray-900 block">Klik untuk upload struk / screenshot</span>
                                <span class="text-xs text-gray-500 mt-1 block">PNG, JPG, JPEG (Max 2MB)</span>
                                <input type="file" id="bukti_transfer" name="bukti_transfer" class="hidden" accept="image/png, image/jpeg, image/jpg" required>
                            </label>
                            @error('bukti_transfer')
                                <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    {{-- Submit --}}
                    <div class="pt-6 border-t border-gray-100 flex items-center justify-between gap-4">
                        <a href="{{ route('cart.index') }}" class="px-6 py-3 text-sm font-bold text-gray-600 bg-gray-100 hover:bg-gray-200 rounded-xl transition">Kembali</a>
                        <button type="submit" class="px-8 py-3 bg-blue-600 text-white text-sm font-bold rounded-xl hover:bg-blue-700 transition shadow-sm active:scale-95 flex items-center gap-2">
                            Kirim & Buat Pesanan
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    // Simple script to show selected file name
    document.getElementById('bukti_transfer').addEventListener('change', function(e) {
        if(e.target.files.length > 0) {
            const fileName = e.target.files[0].name;
            const label = e.target.closest('label');
            label.querySelector('.font-medium').textContent = fileName;
            label.querySelector('.font-medium').classList.add('text-blue-600');
            label.classList.add('border-blue-500', 'bg-blue-50');
        }
    });
</script>
@endsection
