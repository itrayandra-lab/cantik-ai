<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
     @include('meta')
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="stylesheet" href="{{ asset('assets/mix/custom.css') }}">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Alata&family=Itim&family=Lora:ital,wght@0,400..700;1,400..700&family=Onest:wght@100..900&display=swap"
    rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="{{ asset('dist/icon/awesome.js') }}"></script>
    
</head>
@stack('styles')

<body class="bg-white font-sans">
    <div class="min-h-screen flex flex-col">
        <main class="flex-grow">
            <div id="loading-overlay" class="loading-overlay">
                <img src="{{ asset('assets/img/cantikai.png') }}" alt="Loading" class="loading-logo">
            </div>
            @yield('content')
        </main>
        @include('guest.components.footer')
    </div>

</body>
@stack('scripts')
<script src="https://cdn.jsdelivr.net/npm/@tailwindplus/elements@1" type="module"></script>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
      AOS.init();
    </script>
</html>
