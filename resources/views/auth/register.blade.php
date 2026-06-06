@extends('layouts.app')
@section('title', 'Daftar - Rentopia')
@section('content')
<div class="flex items-center justify-center min-h-[calc(100vh-64px)] p-4 bg-gray-50">
    <div class="w-full max-w-md animate-fade-in">
        <div class="text-center mb-8">
            <h1 class="text-3xl font-extrabold font-['Outfit'] text-gray-900 tracking-tight">Buat Akun Baru</h1>
            <p class="text-gray-500 mt-2">Gabung dengan Rentopia sekarang</p>
        </div>

        <div class="bg-white rounded-2xl p-8 shadow-sm border border-gray-100">
            <form method="POST" action="/register" class="space-y-5">
                @csrf
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1.5">Nama Lengkap</label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" required autofocus
                        class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all text-sm"
                        placeholder="John Doe">
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1.5">Alamat Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required
                        class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all text-sm"
                        placeholder="nama@email.com">
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1.5">Password</label>
                    <input type="password" id="password" name="password" required
                        class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all text-sm"
                        placeholder="Minimal 8 karakter">
                </div>

                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1.5">Konfirmasi Password</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" required
                        class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all text-sm"
                        placeholder="Ulangi password">
                </div>

                <div class="pt-2">
                    <button type="submit" class="w-full py-3.5 bg-blue-600 text-white font-semibold rounded-xl hover:bg-blue-700 transition-all shadow-lg shadow-blue-600/20 active:scale-[0.98]">
                        Daftar Akun
                    </button>
                </div>
            </form>

            <div class="mt-8 pt-6 border-t border-gray-100 text-center">
                <p class="text-sm text-gray-500">
                    Sudah punya akun? 
                    <a href="/login" class="font-semibold text-blue-600 hover:text-blue-700 transition">Masuk di sini</a>
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
