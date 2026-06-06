<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProdukController extends Controller
{
    public function index(Request $request)
    {
        $query = Produk::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_produk', 'like', "%{$search}%")
                  ->orWhere('kategori', 'like', "%{$search}%");
            });
        }

        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        $produks = $query->latest()->paginate(10);
        $totalProduk = Produk::count();
        $totalGame = Produk::where('kategori', 'game')->count();
        $totalAndroid = Produk::where('kategori', 'android')->count();

        return view('admin.produk.index', compact('produks', 'totalProduk', 'totalGame', 'totalAndroid'));
    }

    public function create()
    {
        return view('admin.produk.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_produk' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'kategori' => 'required|in:game,android',
            'harga_sewa' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'link_akses' => 'required|url',
        ]);

        if ($request->hasFile('gambar')) {
            $validated['gambar'] = $request->file('gambar')->store('produk', 'public');
        }

        Produk::create($validated);

        return redirect()->route('admin.produk.index')
            ->with('success', 'Produk berhasil ditambahkan!');
    }

    public function edit(Produk $produk)
    {
        return view('admin.produk.edit', compact('produk'));
    }

    public function update(Request $request, Produk $produk)
    {
        $validated = $request->validate([
            'nama_produk' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'kategori' => 'required|in:game,android',
            'harga_sewa' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'link_akses' => 'required|url',
        ]);

        if ($request->hasFile('gambar')) {
            // Hapus gambar lama
            if ($produk->gambar) {
                Storage::disk('public')->delete($produk->gambar);
            }
            $validated['gambar'] = $request->file('gambar')->store('produk', 'public');
        }

        $produk->update($validated);

        return redirect()->route('admin.produk.index')
            ->with('success', 'Produk berhasil diperbarui!');
    }

    public function destroy(Produk $produk)
    {
        // Cek apakah produk sedang disewa (status Menunggu atau Disetujui)
        $activeRentals = $produk->detailPeminjamans()
            ->whereHas('peminjaman', function ($q) {
                $q->whereIn('status', ['Menunggu', 'Disetujui']);
            })->count();

        if ($activeRentals > 0) {
            return back()->with('error', 'Produk tidak dapat dihapus karena sedang dalam proses peminjaman aktif!');
        }

        // Hapus gambar jika ada
        if ($produk->gambar) {
            Storage::disk('public')->delete($produk->gambar);
        }

        $produk->delete();

        return redirect()->route('admin.produk.index')
            ->with('success', 'Produk berhasil dihapus!');
    }
}
