@extends('guest')

@section('title', 'Segera Hadir')

@section('content')
    <div class="min-h-screen bg-gray-900 flex flex-col items-center justify-center relative px-4">
        <div class="absolute top-0 left-0 w-full h-full bg-cover bg-center opacity-30"
            style="background-image: url('https://images.unsplash.com/photo-1604093882750-3ed498f3178b');">
        </div>

        <img src="{{ asset('assets/img/bot.gif') }}" alt="Segera Hadir"
            class="w-48 h-48 z-10 ">

        <h1 class="text-5xl md:text-7xl text-white font-bold mb-4 z-10">Segera Hadir</h1>

        <p class="text-white text-xl md:text-2xl mb-8 z-10">
            Kami sedang bekerja keras untuk menghadirkan sesuatu yang luar biasa. Tetap nantikan!
        </p>

        <div class="z-10 flex flex-col sm:flex-row gap-3 sm:gap-6 items-center">
            <a href="https://wa.me/081329995238" target="_blank" rel="noopener noreferrer"
                class="group inline-flex items-center justify-center bg-green-500 hover:bg-green-600 text-white font-semibold px-5 py-3 rounded-full shadow-lg transition-transform transform hover:-translate-y-0.5">
                <i class="fab fa-whatsapp text-2xl transition-transform duration-200 group-hover:scale-110"></i>
                <span class="ms-3">Hubungi Kami</span>
            </a>

            <a href="{{ url('/') }}"
                class="inline-flex items-center justify-center bg-gray-800 hover:bg-gray-700 text-white font-semibold px-5 py-3 rounded-full shadow-lg transition-transform transform hover:-translate-y-0.5">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="2" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                </svg>
                <span class="ms-3">Kembali</span>
            </a>

        </div>
    </div>
@endsection

@push('scripts')
@endpush
