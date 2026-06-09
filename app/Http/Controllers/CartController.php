<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Peminjaman;
use App\Models\DetailPeminjaman;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    public function index()
    {
        $cart = auth()->user()->cart;
        $items = $cart ? $cart->items()->with('produk')->get() : collect();
        $total = $items->sum(fn ($item) => $item->produk->harga_sewa * $item->qty);

        return view('pembeli.cart.index', compact('items', 'total'));
    }

    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:produks,id',
            'qty' => 'nullable|integer|min:1',
        ]);

        $produk = Produk::findOrFail($request->product_id);
        $qty = $request->qty ?? 1;

        // Buat cart jika belum ada
        $cart = auth()->user()->cart ?? Cart::create(['user_id' => auth()->id()]);

        // Cek apakah produk sudah ada di cart
        $existingItem = $cart->items()->where('product_id', $produk->id)->first();

        if ($existingItem) {
            $newQty = $existingItem->qty + $qty;
            if ($newQty > $produk->stok) {
                return back()->with('error', "Stok tidak mencukupi. Stok tersedia: {$produk->stok}, di keranjang: {$existingItem->qty}.");
            }
            $existingItem->update(['qty' => $newQty]);
        } else {
            if ($qty > $produk->stok) {
                return back()->with('error', "Stok tidak mencukupi. Stok tersedia: {$produk->stok}.");
            }
            $cart->items()->create([
                'product_id' => $produk->id,
                'qty' => $qty,
            ]);
        }

        return back()->with('success', "{$produk->nama_produk} berhasil ditambahkan ke keranjang!");
    }

    public function update(Request $request, CartItem $cartItem)
    {
        $request->validate(['qty' => 'required|integer|min:1']);

        if ($request->qty > $cartItem->produk->stok) {
            return back()->with('error', "Stok tidak mencukupi. Stok tersedia: {$cartItem->produk->stok}.");
        }

        $cartItem->update(['qty' => $request->qty]);

        return back()->with('success', 'Jumlah berhasil diperbarui.');
    }

    public function remove(CartItem $cartItem)
    {
        $cartItem->delete();
        return back()->with('success', 'Item berhasil dihapus dari keranjang.');
    }

    public function checkoutForm(Request $request)
    {
        $cart = auth()->user()->cart;

        if (!$cart || $cart->items->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Keranjang belanja kosong!');
        }

        $itemIds = $request->item_ids;

        if (!$itemIds || count($itemIds) == 0) {
            return redirect()->route('cart.index')->with('error', 'Pilih minimal satu item untuk checkout!');
        }

        $items = $cart->items()->whereIn('id', $itemIds)->with('produk')->get();
        
        if ($items->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Item yang dipilih tidak valid.');
        }

        $total = $items->sum(fn ($item) => $item->produk->harga_sewa * $item->qty);

        return view('pembeli.cart.checkout', compact('items', 'total'));
    }

    public function processCheckout(Request $request)
    {
        $request->validate([
            'metode_pembayaran' => 'required|string',
            'bukti_transfer' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'item_ids' => 'required|array',
            'item_ids.*' => 'exists:cart_items,id',
        ]);

        $cart = auth()->user()->cart;

        if (!$cart || $cart->items->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Keranjang belanja kosong!');
        }

        $selectedItems = $cart->items()->whereIn('id', $request->item_ids)->with('produk')->get();

        if ($selectedItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Pilih minimal satu item valid untuk checkout!');
        }

        try {
            DB::transaction(function () use ($selectedItems, $request) {
                // Upload gambar
                $buktiPath = $request->file('bukti_transfer')->store('bukti_transfer', 'public');

                // Buat peminjaman
                $peminjaman = Peminjaman::create([
                    'user_id' => auth()->id(),
                    'status' => 'Menunggu',
                    'metode_pembayaran' => $request->metode_pembayaran,
                    'bukti_transfer' => $buktiPath,
                ]);

                // Pindahkan cart items ke detail peminjaman
                foreach ($selectedItems as $item) {
                    DetailPeminjaman::create([
                        'peminjaman_id' => $peminjaman->id,
                        'product_id' => $item->product_id,
                        'harga_sewa' => $item->produk->harga_sewa,
                        'qty' => $item->qty,
                    ]);
                    
                    // Hapus item dari keranjang
                    $item->delete();
                }
            });

            return redirect()->route('pembeli.peminjaman.index')
                ->with('success', 'Checkout berhasil! Penyewaan sedang menunggu persetujuan admin.');
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan saat checkout. Silakan coba lagi.')->withInput();
        }
    }
}
