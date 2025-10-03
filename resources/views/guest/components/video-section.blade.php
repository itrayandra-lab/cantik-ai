<section class="bg-white" data-aos="fade-up" data-aos-anchor-placement="top-bottom">
  <div class="max-w-7xl mx-auto rounded-lg">
    <div class="grid grid-cols-1 lg:grid-cols-2">
      
      <!-- Kiri -->
      <div class="bg-indigo-700 p-8 sm:p-12 lg:p-16 flex flex-col justify-center relative overflow-hidden">
        <div class="absolute top-4 right-4 text-blue-500/50" aria-hidden="true">
          <svg width="100" height="100" fill="currentColor">
            <defs>
              <pattern id="dots" x="0" y="0" width="10" height="10" patternUnits="userSpaceOnUse">
                <circle cx="2" cy="2" r="1.5" />
              </pattern>
            </defs>
            <rect x="0" y="0" width="100%" height="100%" fill="url(#dots)" />
          </svg>
        </div>
        
        <div class="relative z-10">
          <p class="text-sm font-semibold text-blue-200 uppercase tracking-wider">
            Watch Our Video
          </p>
          <h1 class="mt-4 text-4xl lg:text-5xl font-extrabold text-white tracking-tight">
            Dream in the Glow of Beauty
          </h1>
          <p class="mt-6 text-base text-blue-100 max-w-lg">
            Our Skincare Line isn’t just about care, it’s about awakening. Like the sun greeting the day, our products reveal the radiant glow inherent in your skin.
          </p>
          <div class="mt-8">
            <a href="#product" class="inline-block px-8 py-3 border border-white text-white font-semibold rounded-lg hover:bg-white hover:text-blue-700 transition-colors duration-300">
              Know More
            </a>
          </div>
        </div>
      </div>

      <!-- Kanan -->
      <div class="relative h-64 sm:h-80 lg:h-auto">
        <img class="w-full h-full object-cover" src="{{ asset('assets/img/banner-3.jpg') }}" alt="Modern architecture">
        <div class="absolute inset-0 bg-black/20 flex items-center justify-center">
          <button onclick="playVideo()" class="group relative w-20 h-20 lg:w-24 lg:h-24 flex items-center justify-center">
            <div class="absolute inset-0 bg-white/30 rounded-full animate-ping group-hover:animate-none"></div>
            <div class="relative bg-blue-600 w-full h-full rounded-full flex items-center justify-center shadow-2xl group-hover:scale-110 transition-transform">
              <svg class="w-1/2 h-1/2 text-white" viewBox="0 0 24 24" fill="currentColor">
                <path d="M8 5.14v14.72L19.78 12 8 5.14z" />
              </svg>
            </div>
          </button>
        </div>

        <!-- Tempat iframe -->
        <div id="video-container" class="absolute inset-0 hidden">
          <iframe class="w-full h-full"
            src="https://www.youtube.com/embed/yjmYxEt0MoE?autoplay=1"
            title="YouTube video player" frameborder="0" allowfullscreen></iframe>
        </div>
      </div>

    </div>
  </div>
</section>

<script>
  function playVideo() {
    document.getElementById('video-container').classList.remove('hidden');
  }
</script>
