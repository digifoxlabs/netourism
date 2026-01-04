<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>NE Tourism</title>
    @vite('resources/css/app.css')
    <!-- Flatpickr CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
  <style>
    .no-scrollbar::-webkit-scrollbar { display: none; }
    .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    html { scroll-behavior: smooth; }
  </style>
</head>

<body id="top" class="min-h-screen flex flex-col bg-white text-gray-800">
  <!-- ================= NAVBAR ================= -->
<header class="sticky top-0 z-50 bg-white border-b border-gray-200">
  <div class="container mx-auto px-4">
    <div class="flex items-center justify-between h-16">
      <!-- Logo -->
      <a href="#top" class="inline-flex items-center gap-2 font-semibold text-lg">
        <img src="/images/logo.jpeg" alt="Logo" class="h-10 w-auto" />
        <span>NE Tourism</span>
      </a>

      <!-- Desktop Nav -->
      <nav class="hidden md:flex items-center gap-8">
        <a href="#top" class="hover:text-brand-600">Home</a>
        <a href="#packages" class="hover:text-brand-600">Packages</a>
        <a href="#contact" class="hover:text-brand-600">Contact</a>
        <a href="#enquiry"
           class="inline-flex items-center rounded-xl bg-brand-600 text-white px-4 py-2 hover:bg-brand-500 transition">
          Book Now
        </a>
      </nav>

      <!-- Mobile trigger -->
      <button id="openDrawerBtn"
              aria-controls="mobileDrawer"
              aria-expanded="false"
              class="md:hidden inline-flex items-center justify-center p-2 rounded-lg border border-gray-300"
              type="button"
              title="Open menu">
        <svg xmlns="http://www.w3.org/2000/svg"
             class="h-6 w-6"
             viewBox="0 0 24 24"
             fill="none"
             stroke="currentColor"
             stroke-width="2">
          <path d="M4 6h16M4 12h16M4 18h16" />
        </svg>
      </button>
    </div>
  </div>

  <!-- Backdrop -->
  <div id="backdrop"
       class="fixed inset-0 bg-black/40 hidden z-40"
       aria-hidden="true"></div>

  <!-- Mobile Drawer -->
  <aside id="mobileDrawer"
         role="dialog"
         aria-modal="true"
         class="fixed inset-y-0 left-0 w-72 max-w-[85%] bg-white border-r border-gray-200 shadow-xl
                -translate-x-full transform transition-transform duration-300 will-change-transform z-50">
    <div class="p-4 flex items-center justify-between border-b bg-white">
      <div class="inline-flex items-center gap-2 font-semibold text-lg">
        <img src="/images/logo.jpeg" alt="Logo" class="h-10 w-auto" />
        <span>NE Tourism</span>
      </div>
      <button id="closeDrawerBtn"
              class="p-2 rounded-lg border border-gray-300 bg-white"
              title="Close menu">
        <svg xmlns="http://www.w3.org/2000/svg"
             class="h-6 w-6"
             viewBox="0 0 24 24"
             fill="none"
             stroke="currentColor"
             stroke-width="2">
          <path d="M6 18L18 6M6 6l12 12"/>
        </svg>
      </button>
    </div>
    <nav class="p-4 flex flex-col gap-3 bg-white">
      <a href="#top" class="px-3 py-2 rounded-lg hover:bg-gray-100">Home</a>
      <a href="#packages" class="px-3 py-2 rounded-lg hover:bg-gray-100">Packages</a>
      <a href="#contact" class="px-3 py-2 rounded-lg hover:bg-gray-100">Contact</a>
      <a href="#enquiry"
         class="mt-2 inline-flex items-center justify-center rounded-xl bg-brand-600 text-white px-4 py-2 hover:bg-brand-500 transition">
        Book Now
      </a>
    </nav>
  </aside>
</header>


  <!-- ================= HERO SLIDER (FULL WIDTH) ================= -->
  <section class="relative z-0 w-full">
    <div class="relative overflow-hidden bg-gray-100">
      <div id="sliderTrack" class="flex transition-transform duration-500 ease-out will-change-transform">
        <div class="relative min-w-full h-[60vh] md:h-[80vh]">
          <img src="images/image1.jpg" alt="Slide 1" class="absolute inset-0 w-full h-full object-cover" />
          <div class="absolute inset-0 bg-black/40"></div>
          <div class="relative z-10 h-full flex flex-col items-start justify-center p-6 md:p-20 text-white">
            <h1 class="text-3xl md:text-6xl font-extrabold leading-tight">Explore the Untouched Northeast</h1>
            <p class="mt-4 md:mt-6 text-lg md:text-xl max-w-2xl text-white/90">From misty mountains to living root bridges—experience landscapes and culture found nowhere else in the world.</p>
          </div>
        </div>
        <div class="relative min-w-full h-[60vh] md:h-[80vh]">
          <img src="images/image2.jpg" alt="Slide 2" class="absolute inset-0 w-full h-full object-cover" />
          <div class="absolute inset-0 bg-black/40"></div>
          <div class="relative z-10 h-full flex flex-col items-start justify-center p-6 md:p-20 text-white">
            <h2 class="text-3xl md:text-6xl font-extrabold leading-tight">Adventure Meets Serenity</h2>
            <p class="mt-4 md:mt-6 text-lg md:text-xl max-w-2xl text-white/90">Curated journeys across mountains, forests, waterfalls, and festivals—crafted for explorers of all kinds.</p>
          </div>
        </div>
        <div class="relative min-w-full h-[60vh] md:h-[80vh]">
          <img src="images/image3.jpg" alt="Slide 3" class="absolute inset-0 w-full h-full object-cover" />
          <div class="absolute inset-0 bg-black/40"></div>
          <div class="relative z-10 h-full flex flex-col items-start justify-center p-6 md:p-20 text-white">
            <h2 class="text-3xl md:text-6xl font-extrabold leading-tight">Travel Beyond the Ordinary</h2>
            <p class="mt-4 md:mt-6 text-lg md:text-xl max-w-2xl text-white/90">Personalized trips with trusted local experts—adventure, culture, wildlife, and pristine natural beauty.</p>
          </div>
        </div>
      </div>

      <button id="prevBtn" class="absolute left-3 top-1/2 -translate-y-1/2 inline-flex items-center justify-center h-10 w-10 rounded-full bg-white/90 hover:bg-white shadow" title="Previous slide" aria-label="Previous slide">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M15 18l-6-6 6-6"/></svg>
      </button>
      <button id="nextBtn" class="absolute right-3 top-1/2 -translate-y-1/2 inline-flex items-center justify-center h-10 w-10 rounded-full bg-white/90 hover:bg-white shadow" title="Next slide" aria-label="Next slide">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 6l6 6-6 6"/></svg>
      </button>

      <div id="dots" class="absolute bottom-4 left-1/2 -translate-x-1/2 flex items-center gap-2"></div>
    </div>
  </section>

 








  <!-- ================= FOOTER ================= -->
  <footer class="mt-auto border-t border-gray-200">
    <div class="container py-8 grid gap-8 md:grid-cols-3">
      <div>
        <div class="inline-flex items-center gap-2 font-semibold text-lg">
          <img src="/images/logo.jpeg" alt="Logo" class="h-10 w-auto" />
          <!-- <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-brand-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 3l9 4.5v9L12 21 3 16.5v-9L12 3z"/></svg> -->
          <span>NE Tourism</span>
        </div>
        <p class="mt-3 text-gray-600">© <span id="year"></span> NE Tourism All rights reserved.</p>
      </div>
      <div class="md:col-span-2 grid grid-cols-2 sm:grid-cols-3 gap-6">
        <div>
          <h4 class="font-semibold">Product</h4>
          <ul class="mt-3 space-y-2 text-gray-600">
            <li><a href="#" class="hover:text-brand-600">Overview</a></li>
            <li><a href="#" class="hover:text-brand-600">Features</a></li>
            <li><a href="#" class="hover:text-brand-600">Pricing</a></li>
          </ul>
        </div>
        <div>
          <h4 class="font-semibold">Company</h4>
          <ul class="mt-3 space-y-2 text-gray-600">
            <li><a href="#" class="hover:text-brand-600">About</a></li>
            <li><a href="#" class="hover:text-brand-600">Careers</a></li>
            <li><a href="#contact" class="hover:text-brand-600">Contact</a></li>
          </ul>
        </div>
        <div>
          <h4 class="font-semibold">Resources</h4>
          <ul class="mt-3 space-y-2 text-gray-600">
            <li><a href="#best-time" class="hover:text-brand-600">Best Time</a></li>
            <li><a href="#planning" class="hover:text-brand-600">Planning</a></li>
            <li><a href="#packages" class="hover:text-brand-600">Packages</a></li>
          </ul>
        </div>
      </div>
    </div>
  </footer>

  <!-- ================= SCRIPTS ================= -->
<!-- ================= SCRIPTS ================= -->
<script>
  // Wait for DOM to be fully loaded


  document.addEventListener('DOMContentLoaded', function() {


  const yearEl = document.getElementById('year');
  if (yearEl) {
    yearEl.textContent = new Date().getFullYear();
  }

  // ===== Mobile Drawer Logic =====
  const openDrawerBtn = document.getElementById('openDrawerBtn');
  const closeDrawerBtn = document.getElementById('closeDrawerBtn');
  const drawer = document.getElementById('mobileDrawer');
  const backdrop = document.getElementById('backdrop');

  function openDrawer() {
    if (!drawer || !backdrop || !openDrawerBtn) return;
    drawer.classList.remove('-translate-x-full');
    drawer.classList.add('translate-x-0');
    backdrop.classList.remove('hidden');
    openDrawerBtn.setAttribute('aria-expanded', 'true');
    document.body.style.overflow = 'hidden';
  }

  function closeDrawer() {
    if (!drawer || !backdrop || !openDrawerBtn) return;
    drawer.classList.remove('translate-x-0');
    drawer.classList.add('-translate-x-full');
    backdrop.classList.add('hidden');
    openDrawerBtn.setAttribute('aria-expanded', 'false');
    document.body.style.overflow = '';
  }

  if (openDrawerBtn && drawer && backdrop) {
    openDrawerBtn.addEventListener('click', openDrawer);
  }

  if (closeDrawerBtn) {
    closeDrawerBtn.addEventListener('click', closeDrawer);
  }

  if (backdrop) {
    backdrop.addEventListener('click', closeDrawer);
  }

  window.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') {
      closeDrawer();
    }
  });

    // Image slider functionality (your existing code)
    const track = document.getElementById('sliderTrack');
    if (track) {
      const slides = Array.from(track.children);
      const prevBtn = document.getElementById('prevBtn');
      const nextBtn = document.getElementById('nextBtn');
      const dots = document.getElementById('dots');

      let index = 0;
      let autoplayInterval = null;
      const AUTOPLAY_MS = 2500;

      function renderDots() {
        if (!dots) return;
        dots.innerHTML = '';
        slides.forEach((_, i) => {
          const b = document.createElement('button');
          b.className = 'h-2.5 w-2.5 rounded-full bg-white/70 hover:bg-white ring-2 ring-white/60 transition-transform duration-200' + (i === index ? ' scale-110 bg-white' : ' opacity-70');
          b.setAttribute('aria-label', `Go to slide ${i + 1}`);
          b.addEventListener('click', () => goTo(i));
          dots.appendChild(b);
        });
      }

      function goTo(i) {
        index = (i + slides.length) % slides.length;
        track.style.transform = `translateX(-${index * 100}%)`;
        renderDots();
      }

      function next() { goTo(index + 1); }
      function prev() { goTo(index - 1); }

      if (nextBtn) nextBtn.addEventListener('click', next);
      if (prevBtn) prevBtn.addEventListener('click', prev);

      function startAutoplay() { 
        stopAutoplay(); 
        autoplayInterval = setInterval(next, AUTOPLAY_MS); 
      }
      
      function stopAutoplay() { 
        if (autoplayInterval) clearInterval(autoplayInterval); 
      }
      
      const sliderWrapper = track.parentElement;
      if (sliderWrapper) {
        sliderWrapper.addEventListener('mouseenter', stopAutoplay);
        sliderWrapper.addEventListener('mouseleave', startAutoplay);
      }

      window.addEventListener('keydown', (e) => {
        if (e.key === 'ArrowRight') next();
        if (e.key === 'ArrowLeft') prev();
      });

      let startX = 0, isDown = false;
      if (sliderWrapper) {
        sliderWrapper.addEventListener('touchstart', (e) => { 
          isDown = true; 
          startX = e.touches[0].clientX; 
          stopAutoplay(); 
        }, { passive: true });
        
        sliderWrapper.addEventListener('touchmove', (e) => {
          if (!isDown) return;
          const dx = e.touches[0].clientX - startX;
          track.style.transform = `translateX(calc(-${index * 100}% + ${dx}px))`;
        }, { passive: true });
        
        sliderWrapper.addEventListener('touchend', (e) => {
          isDown = false;
          const endX = e.changedTouches[0].clientX;
          const dx = endX - startX;
          if (Math.abs(dx) > 50) { 
            dx < 0 ? next() : prev(); 
          } else { 
            goTo(index); 
          }
          startAutoplay();
        });
      }

      renderDots();
      goTo(0);
      startAutoplay();
    }

    // Optional: Add a scroll-to-top button if needed
    // You can add this button to your HTML if you want this functionality
  });
</script>

<!-- Flatpickr JS (only if not already included in your build). If you already include it globally, skip this line) -->
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

