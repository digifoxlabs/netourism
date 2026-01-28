<header class="sticky top-0 z-50 bg-white border-b border-gray-200">
  <div class="container mx-auto px-4">
    <div class="flex items-center justify-between h-16">
      <!-- Logo -->
      <a href="{{ url('/') }}" class="inline-flex items-center gap-2 font-semibold text-lg">
        <img src="{{ asset('/images/logo_n.jpeg') }}?v=1.1" alt="Logo" class="h-10 w-auto" />
        <span>NE Tourism</span>
      </a>

      <!-- Desktop Nav -->
      <nav class="hidden md:flex items-center gap-8">
        <a href="{{ url('/#top') }}" class="hover:text-brand-600">Home</a>
        <a href="{{ url('/#packages') }}" class="hover:text-brand-600">Packages</a>
        <a href="{{ url('/#contact') }}" class="hover:text-brand-600">Contact</a>
        <a href="{{ route('events.index') }}" class="hover:text-brand-600">Events</a>
        <a href="{{ route('affiliate-program') }}" class="hover:text-brand-600 text-decoration-line: underline">Affiliate Program</a>

        <a href="{{ url('/#enquiry') }}"
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
        <img src="{{ asset('/images/logo_n.jpeg') }}?v=1.1" alt="Logo" class="h-10 w-auto" />
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
      <a href="{{ url('/#top') }}" class="px-3 py-2 rounded-lg hover:bg-gray-100">Home</a>
      <a href="{{ url('/#packages') }}" class="px-3 py-2 rounded-lg hover:bg-gray-100">Packages</a>
      <a href="{{ url('/#contact') }}" class="px-3 py-2 rounded-lg hover:bg-gray-100">Contact</a>
      <a href="{{ route('events.index') }}" class="px-3 py-2 rounded-lg hover:bg-gray-100">Events</a>
       <a href="{{ route('affiliate-program') }}" class="px-3 py-2 rounded-lg hover:bg-gray-100">Affiliate Program</a>
      <a href="{{ url('/#enquiry') }}"
         class="mt-2 inline-flex items-center justify-center rounded-xl bg-brand-600 text-white px-4 py-2 hover:bg-brand-500 transition">
        Book Now
      </a>
    </nav>
  </aside>
</header>