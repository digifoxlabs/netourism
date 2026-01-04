<header class="sticky top-0 z-50 bg-white border-b border-gray-200">
  <div class="container mx-auto px-4">
    <div class="flex items-center justify-between h-16">
      <!-- Logo -->
      <a href="{{ url('/') }}" class="inline-flex items-center gap-2 font-semibold text-lg">
        <img src="/images/logo.jpeg" alt="Logo" class="h-10 w-auto" />
        <span>NE Tourism</span>
      </a>

      <!-- Desktop Nav -->
  <nav class="hidden md:flex items-center gap-8">

    <a href="{{ route('admin.dashboard') }}" class="hover:text-brand-600">Dashboard</a>
    <a href="#" class="hover:text-brand-600">Settings</a>

    @auth('admin')
        @php($admin = Auth::guard('admin')->user())
        <!-- Profile Dropdown (no Alpine) -->
        <div class="relative">
            <button
                id="adminProfileBtn"
                type="button"
                class="h-10 w-10 rounded-full bg-gray-200 flex items-center justify-center hover:bg-gray-300 transition cursor-pointer"
            >
                <span class="text-sm font-semibold">
                    {{ strtoupper(mb_substr($admin->name ?? 'A', 0, 1)) }}
                </span>
            </button>

            <div
                id="adminProfileMenu"
                class="hidden absolute right-0 mt-2 w-48 bg-white border border-gray-200 rounded-lg shadow-md py-2 z-50"
            >
                <p class="px-4 py-2 text-sm text-gray-600 border-b">
                    {{ strtoupper($admin->name) }}
                </p>

                {{-- Logout trigger (opens modal) --}}
                <button
                    type="button"
                    id="adminLogoutOpen"
                    class="w-full text-left px-4 py-2 text-sm font-semibold
                        bg-red-50 text-red-600 hover:bg-red-100
                        flex items-center gap-2 cursor-pointer"
                >
                    <!-- Optional icon -->
                    <svg xmlns="http://www.w3.org/2000/svg"
                        class="h-4 w-4"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2">
                        <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
                        <polyline points="16 17 21 12 16 7" />
                        <line x1="21" y1="12" x2="9" y2="12" />
                    </svg>
                    <span>Logout</span>
                </button>



            </div>
        </div>
    @endauth

    @guest('admin')
        <a href="{{ route('admin.login') }}" class="hover:text-brand-600">Login</a>
    @endguest
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
      <a href="{{ route('admin.dashboard') }}" class="px-3 py-2 rounded-lg hover:bg-gray-100">Dashboard</a>
      <a href="#" class="px-3 py-2 rounded-lg hover:bg-gray-100">Settings</a>

      @auth('admin')
          @php($admin = Auth::guard('admin')->user())
          <div class="border-t pt-4">
            <p class="px-3 py-1 text-sm text-gray-600">
              {{ strtoupper($admin->name) }}
            </p>


            <form method="POST" action="{{ route('admin.logout') }}">
              @csrf
              <button type="submit"
                      class="w-full text-left px-3 py-2 rounded-lg hover:bg-gray-100 text-gray-700 cursor-pointer">
                Logout
              </button>
            </form>




            
          </div>
      @endauth

      @guest('admin')
          <a href="{{ route('admin.login') }}" class="px-3 py-2 rounded-lg hover:bg-gray-100">Login</a>
      @endguest
    </nav>
  </aside>
</header>
