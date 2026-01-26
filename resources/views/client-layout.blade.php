<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Google tag (gtag.js) -->
  <script async src="https://www.googletagmanager.com/gtag/js?id=G-RVZ656QTM6"></script>
  <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());
    gtag('config', 'G-RVZ656QTM6');
  </script>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>NE Tourism</title>
      @vite(['resources/css/app.css', 'resources/js/app.js'])
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
  <style>
    [x-cloak] { display: none !important; }


.no-scrollbar::-webkit-scrollbar {
    display: none;
}
.no-scrollbar {
    -ms-overflow-style: none;
    scrollbar-width: none;
}





</style>

</head>

<body id="top" class="min-h-screen flex flex-col bg-white text-gray-800">


@include ('client.partials.navbar')


@yield('page-content')






  <!-- ================= FOOTER ================= -->
  <footer class="mt-auto border-t border-gray-200">
    <div class="container py-8 grid gap-8 md:grid-cols-3">

<div>
    <div class="inline-flex items-center gap-2 font-semibold text-lg">
        <img src="/images/logo.jpeg" alt="Logo" class="h-10 w-auto" />
        <span>NE Tourism</span>
    </div>

    <p class="mt-3 text-gray-600">
        © <span id="year"></span> NE Tourism. All rights reserved.
    </p>

    {{-- Social Links --}}
    <div class="mt-5 flex items-center gap-4">

        {{-- Facebook --}}
        <div class="relative group">
            <a href="https://www.facebook.com/share/14SUZJnkkrg/?mibextid=wwXIfr"
               target="_blank"
               rel="noopener"
               class="flex h-11 w-11 items-center justify-center rounded-full
                      bg-blue-600 text-white shadow-sm transition
                      hover:-translate-y-1 hover:shadow-lg hover:bg-blue-500">

                <i class="fa-brands fa-facebook-f text-lg"></i>
            </a>

            {{-- Tooltip --}}
            <span
                class="pointer-events-none absolute -top-10 left-1/2 -translate-x-1/2
                       rounded-md bg-slate-900 px-2 py-1 text-[11px] text-white
                       opacity-0 transition
                       group-hover:opacity-100"
            >
                Facebook
            </span>
        </div>

        {{-- Instagram --}}
        <div class="relative group">
            <a href="https://www.instagram.com/_netourism?igsh=eHNpaHBnZW1nd2Ft&utm_source=qr"
               target="_blank"
               rel="noopener"
               class="flex h-11 w-11 items-center justify-center rounded-full
                      bg-gradient-to-tr from-pink-500 via-purple-500 to-yellow-400
                      text-white shadow-sm transition
                      hover:-translate-y-1 hover:shadow-lg hover:scale-105">

                <i class="fa-brands fa-instagram text-lg"></i>
            </a>

            {{-- Tooltip --}}
            <span
                class="pointer-events-none absolute -top-10 left-1/2 -translate-x-1/2
                       rounded-md bg-slate-900 px-2 py-1 text-[11px] text-white
                       opacity-0 transition
                       group-hover:opacity-100"
            >
                Instagram
            </span>
        </div>

    </div>
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

    <!-- ================= SCROLL TO TOP (bottom of page) ================= -->
{{-- <section class="container pb-8">
    <div class="text-center">
      <button id="scrollTopBtn" class="inline-flex items-center gap-2 rounded-xl border px-4 py-2 hover:bg-gray-50" type="button">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 19V5M5 12l7-7 7 7"/></svg>
        Back to top
      </button>
    </div>
</section> --}}




<!-- Flatpickr JS (only if not already included in your build). If you already include it globally, skip this line) -->
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

  <!-- ================= SCRIPTS ================= -->
<script>

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
    // Scroll-to-top button
    const scrollTopBtn = document.getElementById('scrollTopBtn');
    if (scrollTopBtn) {
      scrollTopBtn.addEventListener('click', () => {
        window.scrollTo({ top: 0, behavior: 'smooth' });
      });
    }


  });
</script>







@stack('scripts')







<!-- Floating WhatsApp Chat Widget (No Alpine) -->
<div
    id="waWidget"
    class="fixed left-4 bottom-5 z-50 flex flex-col items-start space-y-3"
>
    <!-- Card: visible only on md and above -->
    <div
        id="waCard"
        class="hidden md:block mb-2 w-72 rounded-2xl bg-slate-900/95 text-slate-50
               shadow-xl shadow-emerald-500/40 border border-emerald-400/60
               backdrop-blur px-4 py-3"
    >
        <div class="flex items-start justify-between gap-2">
            <div>
                <div class="flex items-center gap-2">
                    <div
                        class="flex h-8 w-8 items-center justify-center rounded-full
                               bg-gradient-to-tr from-emerald-500 via-green-500 to-lime-400
                               shadow-[0_0_12px_rgba(34,197,94,0.9)]"
                    >
                        <!-- WhatsApp icon -->
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32"
                             class="h-5 w-5 text-white">
                            <path fill="currentColor"
                                  d="M16 3C9.935 3 5 7.935 5 14c0 2.081.557 4.02 1.525 5.713L5 27l7.48-1.958A11.02 11.02 0 0 0 16 25c6.065 0 11-4.935 11-11S22.065 3 16 3Zm0 2c4.971 0 9 4.029 9 9s-4.029 9-9 9a8.99 8.99 0 0 1-4.578-1.266l-.33-.2-4.463 1.168 1.192-4.347-.215-.343A8.963 8.963 0 0 1 7 14c0-4.971 4.029-9 9-9Zm-3.32 4.999c-.188 0-.492.07-.75.35s-.984.961-.984 2.343c0 1.382 1.008 2.718 1.148 2.908.14.19 1.984 3.167 4.828 4.309 2.391.947 2.876.852 3.387.799.511-.053 1.668-.681 1.903-1.339.235-.658.235-1.223.164-1.339-.07-.116-.258-.188-.54-.329-.282-.141-1.668-.824-1.925-.918-.257-.094-.445-.141-.633.141-.188.282-.726.918-.89 1.106-.164.188-.329.212-.611.071-.282-.141-1.189-.438-2.266-1.396-.838-.747-1.403-1.668-1.567-1.95-.164-.282-.018-.435.123-.576.126-.125.282-.329.423-.494.141-.165.188-.283.282-.471.094-.188.047-.353-.024-.494-.07-.141-.618-1.488-.874-2.037-.228-.49-.468-.53-.656-.536Z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-semibold">Chat with us on WhatsApp</p>
                        <p class="text-xs text-slate-300">
                            Typically responds within a few minutes.
                        </p>
                    </div>
                </div>
            </div>
            <button
                type="button"
                id="waCardClose"
                class="text-slate-400 hover:text-slate-200 text-xs"
            >
                ✕
            </button>
        </div>

        <div class="mt-3 text-xs text-slate-200">
            <p>Hi! How can we help you today?</p>
        </div>

        <div class="mt-3">
            <a
                href="https://wa.me/916001553100?text={{ urlencode('Hi, I need some help on your website.') }}"
                target="_blank"
                rel="noopener"
                class="flex w-full items-center justify-center gap-2
                       rounded-xl bg-emerald-500/90 px-3 py-2 text-sm font-semibold
                       text-white shadow-md shadow-emerald-500/50
                       hover:bg-emerald-400 transition"
            >
                <span>Open WhatsApp</span>
            </a>
        </div>
    </div>

    <!-- Mobile Icon-only (visible below md) -->
<a
    href="https://wa.me/916001553100?text={{ urlencode('Hi, I need some help on your website.') }}"
    target="_blank"
    rel="noopener"
    class="flex h-14 w-14 items-center justify-center rounded-full
           bg-gradient-to-tr from-emerald-500 via-green-500 to-lime-400
           shadow-[0_0_22px_rgba(34,197,94,0.95)]
           border border-emerald-300/70
           hover:scale-105 active:scale-95 transition-transform"
        aria-label="Chat on WhatsApp"
>

        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32"
             class="h-7 w-7 text-white drop-shadow-[0_0_8px_rgba(15,23,42,0.7)]">
            <path fill="currentColor"
                  d="M16 3C9.935 3 5 7.935 5 14c0 2.081.557 4.02 1.525 5.713L5 27l7.48-1.958A11.02 11.02 0 0 0 16 25c6.065 0 11-4.935 11-11S22.065 3 16 3Zm0 2c4.971 0 9 4.029 9 9s-4.029 9-9 9a8.99 8.99 0 0 1-4.578-1.266l-.33-.2-4.463 1.168 1.192-4.347-.215-.343A8.963 8.963 0 0 1 7 14c0-4.971 4.029-9 9-9Zm-3.32 4.999c-.188 0-.492.07-.75.35s-.984.961-.984 2.343c0 1.382 1.008 2.718 1.148 2.908.14.19 1.984 3.167 4.828 4.309 2.391.947 2.876.852 3.387.799.511-.053 1.668-.681 1.903-1.339.235-.658.235-1.223.164-1.339-.07-.116-.258-.188-.54-.329-.282-.141-1.668-.824-1.925-.918-.257-.094-.445-.141-.633.141-.188.282-.726.918-.89 1.106-.164.188-.329.212-.611.071-.282-.141-1.189-.438-2.266-1.396-.838-.747-1.403-1.668-1.567-1.95-.164-.282-.018-.435.123-.576.126-.125.282-.329.423-.494.141-.165.188-.283.282-.471.094-.188.047-.353-.024-.494-.07-.141-.618-1.488-.874-2.037-.228-.49-.468-.53-.656-.536Z" />
        </svg>
    </a>
</div>


{{-- <script>
    document.addEventListener('DOMContentLoaded', () => {
        const waCard = document.getElementById('waCard');
        const waClose = document.getElementById('waCardClose');

        if (waCard && waClose) {
            waClose.addEventListener('click', () => {
                waCard.classList.add('hidden');
            });
        }
    });
</script> --}}







<!-- Scroll to Top Button -->
<!-- Scroll To Top: Circular Glowing Button with Progress -->
<button
    id="scrollToTopBtn"
    class="fixed bottom-5 right-5 z-50 hidden
           flex items-center justify-center
           rounded-full
           bg-slate-900/80
           shadow-lg shadow-cyan-400/40
           hover:shadow-cyan-400/80
           transition
           backdrop-blur
           border border-cyan-400/60
           w-14 h-14
           group"
    aria-label="Scroll to top"
>
    <!-- Progress Ring -->
    <svg
        class="absolute inset-0 w-full h-full -rotate-90"
        viewBox="0 0 48 48"
    >
        <!-- Background circle -->
        <circle
            class="text-slate-800"
            stroke="currentColor"
            stroke-width="4"
            fill="transparent"
            r="20"
            cx="24"
            cy="24"
        />
        <!-- Progress circle -->
        <circle
            id="scrollProgressCircle"
            class="text-cyan-400"
            stroke="currentColor"
            stroke-width="4"
            fill="transparent"
            stroke-linecap="round"
            r="20"
            cx="24"
            cy="24"
        />
    </svg>

    <!-- Inner glowing core with arrow -->
    <div
        class="relative flex items-center justify-center
               w-10 h-10 rounded-full
               bg-gradient-to-tr from-cyan-500 via-sky-500 to-emerald-400
               shadow-[0_0_18px_rgba(34,211,238,0.9)]
               group-hover:scale-105
               transition-transform"
    >
        <span
            class="text-white text-xl leading-none
                   drop-shadow-[0_0_6px_rgba(15,23,42,0.7)]"
        >
            ↑
        </span>
    </div>
</button>




<script>
    document.addEventListener('DOMContentLoaded', () => {
        const scrollBtn = document.getElementById('scrollToTopBtn');
        const progressCircle = document.getElementById('scrollProgressCircle');

        if (!scrollBtn || !progressCircle) return;

        const radius = progressCircle.r.baseVal.value;
        const circumference = 2 * Math.PI * radius;

        // Setup the stroke dash
        progressCircle.style.strokeDasharray = `${circumference} ${circumference}`;
        progressCircle.style.strokeDashoffset = `${circumference}`;

        function setProgress() {
            const scrollTop = window.scrollY || window.pageYOffset;
            const docHeight = document.documentElement.scrollHeight - window.innerHeight;

            const progress = docHeight > 0 ? scrollTop / docHeight : 0;
            const offset = circumference - progress * circumference;

            progressCircle.style.strokeDashoffset = offset;

            // Show button after some scrolling
            if (scrollTop > 200) {
                scrollBtn.classList.remove('hidden');
            } else {
                scrollBtn.classList.add('hidden');
            }
        }

        // Update on scroll & on load
        window.addEventListener('scroll', setProgress);
        setProgress();

        // Smooth scroll to top
        scrollBtn.addEventListener('click', () => {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });



    const closeBtn = document.getElementById("waCardClose");
    const card = document.getElementById("waCard");

    card.style.display = "none"; // Ensure the card is visible initially

    if (closeBtn && card) {
        closeBtn.addEventListener("click", function () {
            card.style.display = "none";   // <--- guaranteed to work
        });
    }


    });
</script>






</body>

</html>
