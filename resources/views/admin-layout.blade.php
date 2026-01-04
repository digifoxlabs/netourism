<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>NE Tourism | Admin</title>
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
</style>

</head>

<body id="top" class="min-h-screen flex flex-col bg-white text-gray-800">


@include ('admin.partials.navbar')


@yield('page-content')






  <!-- ================= FOOTER ================= -->
<footer class="mt-auto border-t border-gray-200 dark:border-gray-800 bg-white dark:bg-slate-950">
    <div class="container py-8 grid gap-8 md:grid-cols-3 items-center">

        {{-- Left: Brand / Name (optional) --}}
        <div class="text-sm text-gray-600 dark:text-gray-400 md:text-left text-center">
            <span class="font-semibold text-gray-800 dark:text-gray-100">
                NE Tourism Admin Panel
            </span>
        </div>

        {{-- Center: Copyright --}}
        <div class="text-sm text-gray-500 dark:text-gray-400 text-center">
            &copy; {{ date('Y') }} NE Tourism. All rights reserved.
        </div>

        {{-- Right: Simple links (optional) --}}
        <div class="flex justify-center md:justify-end gap-4 text-xs text-gray-500 dark:text-gray-400">
            <a href="#" class="hover:text-gray-900 dark:hover:text-gray-100 transition">
                Privacy Policy
            </a>
            <span class="text-gray-300 dark:text-gray-600">|</span>
            <a href="#" class="hover:text-gray-900 dark:hover:text-gray-100 transition">
                Terms
            </a>
        </div>

    </div>
</footer>



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



    });
</script>


<script>
document.addEventListener('DOMContentLoaded', function () {
    const btn  = document.getElementById('adminProfileBtn');
    const menu = document.getElementById('adminProfileMenu');

    if (!btn || !menu) return;

    // Toggle menu on button click
    btn.addEventListener('click', function (e) {
        e.stopPropagation();
        menu.classList.toggle('hidden');
    });

    // Close on outside click
    document.addEventListener('click', function (e) {
        if (!menu.classList.contains('hidden')) {
            // If click is outside the button and menu, hide it
            if (!menu.contains(e.target) && !btn.contains(e.target)) {
                menu.classList.add('hidden');
            }
        }
    });

    // Close on Escape key
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') {
            menu.classList.add('hidden');
        }
    });
});
</script>


<!-- Admin Logout Confirmation Modal -->
<div
    id="adminLogoutModal"
    class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50"
>
    <div class="bg-white rounded-xl shadow-xl max-w-sm w-full mx-4 p-6">
        <h2 class="text-lg font-semibold text-gray-900">
            Confirm Logout
        </h2>
        <p class="mt-2 text-sm text-gray-600">
            Are you sure you want to log out of your admin account?
        </p>

        <div class="mt-6 flex justify-end gap-3">
            <button
                type="button"
                id="adminLogoutCancel"
                class="px-4 py-2 rounded-lg border border-gray-300 text-sm
                       text-gray-700 hover:bg-gray-100"
            >
                Cancel
            </button>

            <form
                id="adminLogoutForm"
                method="POST"
                action="{{ route('admin.logout') }}"
            >
                @csrf
                <button
                    type="submit"
                    class="px-4 py-2 rounded-lg bg-red-600 text-white text-sm
                           hover:bg-red-500"
                >
                    Logout
                </button>
            </form>
        </div>
    </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const openBtn   = document.getElementById('adminLogoutOpen');
    const modal     = document.getElementById('adminLogoutModal');
    const cancelBtn = document.getElementById('adminLogoutCancel');

    if (!openBtn || !modal || !cancelBtn) return;

    function openModal() {
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function closeModal() {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }

    // Open on logout button click
    openBtn.addEventListener('click', function (e) {
        e.stopPropagation();
        openModal();
    });

    // Cancel button
    cancelBtn.addEventListener('click', function () {
        closeModal();
    });

    // Click outside modal content to close
    modal.addEventListener('click', function (e) {
        if (e.target === modal) {
            closeModal();
        }
    });

    // Escape key to close
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') {
            closeModal();
        }
    });
});
</script>




{{-- <script>
document.addEventListener('alpine:init', () => {
    Alpine.data('emailTemplateEditor', ({ initialTemplate, placeholders, systemPlaceholders }) => ({
        template: initialTemplate || '',
        allPlaceholders: [...placeholders, ...systemPlaceholders],

        sampleData: {
            full_name: 'John Doe',
            email: 'john@example.com',
            mobile: '9876543210',
            event_title: 'Alfresco 2.0 – Kaziranga',
            fee: '₹2,299'
        },

        insert(ph) {
            this.template += ` {{${ph}}}`;
        },

        get preview() {
            let out = this.template;

            Object.entries(this.sampleData).forEach(([k,v]) => {
                out = out.replace(new RegExp(`{{\\s*${k}\\s*}}`, 'g'), v);
            });

            return out || '<span class="text-slate-400">Live email preview…</span>';
        }
    }))
})
</script> --}}

{{-- <script>
document.addEventListener('alpine:init', () => {
    Alpine.data('emailTemplateEditor', (config) => ({
        template: config.initialTemplate || '',

        allPlaceholders: []
            .concat(config.placeholders || [])
            .concat(config.systemPlaceholders || []),

        sampleData: {
            full_name: 'John Doe',
            email: 'john@example.com',
            mobile: '9876543210',
        },

        insert(ph) {
            this.template += ' {{' + ph + '}}';
        },

        previewHtml() {
            let out = this.template;

            for (const key in this.sampleData) {
                const placeholder = '{{' + key + '}}';
                out = out.split(placeholder).join(this.sampleData[key]);
            }

            return out && out.trim()
                ? out
                : '<span class="text-slate-400">Email preview…</span>';
        }
    }));
});
</script> --}}


{{-- @verbatim
<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('emailTemplateEditor', ({
        initialTemplate,
        placeholders = [],
        systemPlaceholders = []
    }) => ({
        template: initialTemplate || '',

        // normalize placeholders
        allPlaceholders: [
            ...placeholders.map(p => typeof p === 'string' ? p : p.name),
            ...systemPlaceholders
        ],

        sampleData: {
            full_name: 'John Doe',
            email: 'john@example.com',
            mobile: '9876543210',
        },

        insert(key) {
            this.template += ' {{' + key + '}}';
        },

        get preview() {
            let out = this.template;

            Object.entries(this.sampleData).forEach(([k, v]) => {
                const pattern = new RegExp('{{\\s*' + k + '\\s*}}', 'g');
                out = out.replace(pattern, v);
            });

            return out || '<span class="text-slate-400">Email preview…</span>';
        }
    }));
});
</script>
@endverbatim --}}


{{-- @verbatim
<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('emailTemplateEditor', ({
        initialTemplate = '',
        placeholders = [],
        systemPlaceholders = []
    }) => ({
        template: initialTemplate,
        allPlaceholders: [],

        sampleData: {
            full_name: 'John Doe',
            email: 'john@example.com',
            mobile: '9876543210',
        },

        init() {
            this.allPlaceholders = [
                ...placeholders.map(p => typeof p === 'string' ? p : p.name),
                ...systemPlaceholders
            ].filter(Boolean);
        },

        insert(key) {
            this.template += ' {{' + key + '}}';
        },

        previewHtml() {
            let out = this.template || '';

            Object.entries(this.sampleData).forEach(([k, v]) => {
                out = out.replace(
                    new RegExp('{{\\s*' + k + '\\s*}}', 'g'),
                    v
                );
            });

            return out || '<span class="text-slate-400">Email preview…</span>';
        }
    }));
});
</script>
@endverbatim --}}



@verbatim
<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('emailTemplateEditor', ({
        initialTemplate = '',
        placeholders = [],
        systemPlaceholders = []
    }) => ({
        template: initialTemplate,

        // 🔹 normalize placeholders (strings only)
        allPlaceholders: [
            ...placeholders.filter(Boolean),
            ...systemPlaceholders
        ],

        // 🔹 sample data for preview
        sampleData: {
            full_name: 'John Doe',
            email: 'john@example.com',
            mobile: '9876543210',
        },

        insert(key) {
            this.template += ` {{${key}}}`;
        },

        preview() {
            let out = this.template || '';

            Object.entries(this.sampleData).forEach(([k, v]) => {
                const re = new RegExp(`{{\\s*${k}\\s*}}`, 'g');
                out = out.replace(re, v);
            });

            return out || '<span class="text-slate-400">Email preview…</span>';
        }
    }));
});
</script>
@endverbatim






</body>

</html>
