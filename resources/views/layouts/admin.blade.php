<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Admin Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        #sidebar.sidebar-initializing .sidebar-text {
            display: none;
        }

        .sidebar-collapsed .sidebar-text {
            display: none;
        }

        #mobileHamburger {
            position: fixed;
            top: 1rem;
            left: 1rem;
            z-index: 60;
            background: white;
            padding: 0.5rem;
            border-radius: 0.375rem;
            box-shadow: 0 2px 6px rgb(0 0 0 / 0.15);
            transition: left 0.3s ease;
            display: none;
        }

        #mobileHamburger.shifted {
            left: 14rem; 
            background-color: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(8px);
        }

        @media (max-width: 767px) {
            #mobileHamburger {
                display: block;
            }
        }

        .icon-hidden {
            display: none;
        }
    </style>
</head>

<body class="bg-gray-100">

    <div class="flex h-screen overflow-hidden">

        <div id="sidebar"
            class="sidebar-initializing bg-white shadow-md w-64 fixed inset-y-0 left-0 z-40 transform transition-all duration-300 ease-in-out flex flex-col p-4
               -translate-x-full md:translate-x-0 md:relative">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-xl font-bold text-gray-800 sidebar-text">Admin Panel</h2>
                <button id="sidebarToggle" class="text-gray-600 hover:text-indigo-600 hidden md:block">
                    <i data-lucide="menu" class="w-6 h-6"></i>
                </button>
            </div>
            <p class="text-sm text-gray-600 sidebar-text mb-6">Login sebagai:
                <strong>{{ session('admin_nama') }}</strong>
            </p>

            <nav class="flex-1 space-y-2 overflow-auto">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center p-2 rounded hover:bg-gray-200">
                    <i data-lucide="home" class="w-5 h-5"></i>
                    <span class="ml-3 sidebar-text">Dashboard</span>
                </a>
                <a href="{{ route('admin-buns.gallery') }}" class="flex items-center p-2 rounded hover:bg-gray-200">
                    <i data-lucide="image" class="w-5 h-5"></i>
                    <span class="ml-3 sidebar-text">Gallery</span>
                </a>
                <a href="{{ route('admin-buns.users.index') }}" class="flex items-center p-2 rounded hover:bg-gray-200">
                    <i data-lucide="users" class="w-5 h-5"></i>
                    <span class="ml-3 sidebar-text">Users</span>
                </a>
                <a href="{{ route('admin-buns.members.index') }}" class="flex items-center p-2 rounded hover:bg-gray-200">
                    <i data-lucide="credit-card" class="w-5 h-5"></i>
                    <span class="ml-3 sidebar-text">Members</span>
                </a>
                <a href="{{ route('admin-buns.classes.index') }}"
                    class="flex items-center p-2 rounded hover:bg-gray-200">
                    <i data-lucide="book-open" class="w-5 h-5"></i>
                    <span class="ml-3 sidebar-text">Classes</span>
                </a>
                <form method="POST" action="{{ route('admin.logout') }}">
                    @csrf
                    <button class="flex items-center w-full p-2 rounded hover:bg-red-100 text-red-600">
                        <i data-lucide="log-out" class="w-5 h-5"></i>
                        <span class="ml-3 sidebar-text">Logout</span>
                    </button>
                </form>
            </nav>
        </div>

        <div id="overlay" class="fixed inset-0 bg-black bg-opacity-40 z-30 hidden"></div>

        <div id="mainContent" class="flex-1 h-screen overflow-y-auto p-6 transition-all duration-300 ease-in-out">
            @yield('content')
        </div>
    </div>

    <button id="mobileHamburger" aria-label="Toggle Sidebar Mobile">
        <i data-lucide="menu" class="menu-icon w-6 h-6 text-gray-600 hover:text-indigo-600"></i>
        <i data-lucide="x" class="x-icon icon-hidden w-6 h-6 text-gray-600 hover:text-indigo-600"></i>
    </button>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            lucide.createIcons();

            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('overlay');
            const mobileHamburger = document.getElementById('mobileHamburger');
            const sidebarToggle = document.getElementById('sidebarToggle');
            
            // Icons for mobile hamburger toggle
            const menuIcon = mobileHamburger.querySelector('.menu-icon');
            const xIcon = mobileHamburger.querySelector('.x-icon');

            const SIDEBAR_COLLAPSE_KEY = 'sidebar_collapsed_state';
            let isCollapsed = false;

            function setSidebarCollapseState(collapsed) {
                localStorage.setItem(SIDEBAR_COLLAPSE_KEY, collapsed ? 'true' : 'false');
            }

            function getSidebarCollapseState() {
                return localStorage.getItem(SIDEBAR_COLLAPSE_KEY) === 'true';
            }

            // Desktop collapse toggle
            if (sidebarToggle) {
                sidebarToggle.addEventListener('click', () => {
                    if (window.innerWidth >= 768) {
                        isCollapsed = !isCollapsed;
                        sidebar.classList.toggle('w-64');
                        sidebar.classList.toggle('w-16');
                        sidebar.classList.toggle('sidebar-collapsed');
                        setSidebarCollapseState(isCollapsed);
                    }
                });
            }

            // Mobile toggle sidebar slide & overlay
            function toggleSidebarMobile() {
                const isSidebarHiddenOffScreen = sidebar.classList.contains('-translate-x-full');

                if (isSidebarHiddenOffScreen) {
                    sidebar.classList.remove('-translate-x-full');
                    sidebar.classList.add('translate-x-0');
                    if(menuIcon) menuIcon.classList.add('icon-hidden');
                    if(xIcon) xIcon.classList.remove('icon-hidden');
                } else {
                    sidebar.classList.remove('translate-x-0');
                    sidebar.classList.add('-translate-x-full');
                    if(menuIcon) menuIcon.classList.remove('icon-hidden');
                    if(xIcon) xIcon.classList.add('icon-hidden');
                }

                overlay.classList.toggle('hidden');
                document.body.classList.toggle('overflow-hidden')
                mobileHamburger.classList.toggle('shifted');
            }

            if (mobileHamburger) {
                mobileHamburger.addEventListener('click', toggleSidebarMobile);
            }
            if (overlay) {
                overlay.addEventListener('click', toggleSidebarMobile);
            }

            function resetSidebar() {
                if (window.innerWidth < 768) {
                    // Mobile view
                    sidebar.classList.add('-translate-x-full');
                    sidebar.classList.remove('translate-x-0'); 
                    overlay.classList.add('hidden');
                    document.body.classList.remove('overflow-hidden');
                    
                    if (mobileHamburger) mobileHamburger.classList.remove('shifted');
                    if (menuIcon) menuIcon.classList.remove('icon-hidden');
                    if (xIcon) xIcon.classList.add('icon-hidden');

                    sidebar.classList.remove('w-16', 'sidebar-collapsed');
                    sidebar.classList.add('w-64'); 
                    isCollapsed = false; 
                } else {
                    // Desktop view
                    sidebar.classList.remove('-translate-x-full');
                    overlay.classList.add('hidden');
                    document.body.classList.remove('overflow-hidden');

                    const savedState = getSidebarCollapseState();
                    isCollapsed = savedState;

                    if (savedState) {
                        sidebar.classList.remove('w-64');
                        sidebar.classList.add('w-16', 'sidebar-collapsed');
                    } else {
                        sidebar.classList.add('w-64');
                        sidebar.classList.remove('w-16', 'sidebar-collapsed');
                    }
                }
                sidebar.classList.remove('sidebar-initializing');
            }

            resetSidebar();
            window.addEventListener('resize', resetSidebar);
        });
    </script>

</body>
</html>
