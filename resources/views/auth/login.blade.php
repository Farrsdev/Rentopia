@extends('layouts.app')
@section('title', 'Masuk - Rentopia')
@section('content')
<div class="flex items-center justify-center min-h-[calc(100vh-64px)] p-4 bg-gray-50">
    <div class="w-full max-w-md animate-fade-in">
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-blue-600 rounded-2xl mb-4 shadow-xl shadow-blue-600/20">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/></svg>
            </div>
            <h1 class="text-3xl font-extrabold font-['Outfit'] text-gray-900 tracking-tight">Selamat Datang</h1>
            <p class="text-gray-500 mt-2">Masuk ke akun Rentopia Anda</p>
        </div>

        <div class="bg-white rounded-2xl p-8 shadow-sm border border-gray-100">
            <form method="POST" action="/login" class="space-y-6">
                @csrf
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Alamat Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus
                        class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all text-sm"
                        placeholder="nama@email.com">
                </div>

                <div>
                    <div class="flex items-center justify-between mb-2">
                        <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                        <a href="#" class="text-xs font-semibold text-blue-600 hover:text-blue-700">Lupa password?</a>
                    </div>
                    <input type="password" id="password" name="password" required
                        class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all text-sm"
                        placeholder="••••••••">
                </div>

                <div class="flex items-center">
                    <input type="checkbox" id="remember" name="remember" class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500 cursor-pointer">
                    <label for="remember" class="ml-2 block text-sm text-gray-600 cursor-pointer">Ingat saya</label>
                </div>

                <button type="submit" class="w-full py-3.5 bg-blue-600 text-white font-semibold rounded-xl hover:bg-blue-700 transition-all shadow-lg shadow-blue-600/20 active:scale-[0.98] flex items-center justify-center gap-2">
                    <span>Masuk</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                </button>
            </form>

            <div class="mt-8 pt-6 border-t border-gray-100 text-center">
                <p class="text-sm text-gray-500">
                    Belum punya akun? 
                    <a href="/register" class="font-semibold text-blue-600 hover:text-blue-700 transition">Daftar sekarang</a>
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
