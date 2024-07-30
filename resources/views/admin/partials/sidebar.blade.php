<!-- BEGIN: Sidebar -->
<div class="sidebar-wrapper group">
    <div id="bodyOverlay" class="w-screen h-screen fixed top-0 bg-slate-900 bg-opacity-50 backdrop-blur-sm z-10 hidden">
    </div>
    <div class="logo-segment">
        <a class="flex items-center" href="{{ route('dashboard') }}">
            <img src="{{ asset('backend/images/logo/logo-c.svg') }}" class="black_logo" alt="logo">
            <img src="{{ asset('backend/images/logo/logo-c-white.svg') }}" class="white_logo" alt="logo">
            <span class="ltr:ml-3 rtl:mr-3 text-xl font-Inter font-bold text-slate-900 dark:text-white">DashCode</span>
        </a>
        <!-- Sidebar Type Button -->
        <div id="sidebar_type" class="cursor-pointer text-slate-900 dark:text-white text-lg">
            <iconify-icon class="sidebarDotIcon extend-icon text-slate-900 dark:text-slate-200"
                icon="fa-regular:dot-circle"></iconify-icon>
            <iconify-icon class="sidebarDotIcon collapsed-icon text-slate-900 dark:text-slate-200"
                icon="material-symbols:circle-outline"></iconify-icon>
        </div>
        <button class="sidebarCloseIcon text-2xl">
            <iconify-icon class="text-slate-900 dark:text-slate-200" icon="clarity:window-close-line"></iconify-icon>
        </button>
    </div>
    <div id="nav_shadow"
        class="nav_shadow h-[60px] absolute top-[80px] nav-shadow z-[1] w-full transition-all duration-200 pointer-events-none
    opacity-0">
    </div>
    <div class="sidebar-menus bg-white dark:bg-slate-800 py-2 px-4 h-[calc(100%-80px)] overflow-y-auto z-50"
        id="sidebar_menus">
        @php
            $route = Route::currentRouteName();
        @endphp
        <ul class="sidebar-menu">
            <li class="sidebar-menu-title">HOME</li>
            <li class="">
                <a href="{{ route('admin.dashboard') }}"
                    class="navItem {{ $route == 'admin.dashboard' ? 'active' : '' }}">
                    <span class="flex items-center">
                        <iconify-icon class=" nav-icon" icon="heroicons-outline:home"></iconify-icon>
                        <span>Home</span>
                    </span>
                </a>
            </li>

            <li class="sidebar-menu-title">Transaction</li>
            <li class="">
                <a href="{{ route('admin.borrow.borrow') }}"
                    class="navItem {{ $route == 'admin.borrow.borrow' ? 'active' : '' }}">
                    <span class="flex items-center">
                        <iconify-icon class=" nav-icon" icon="heroicons-outline:arrow-up-tray"></iconify-icon>
                        <span>Peminjaman</span>
                    </span>
                </a>
            </li>

            <li class="">
                <a href="{{ route('admin.return.return') }}"
                    class="navItem {{ $route == 'admin.return.return' ? 'active' : '' }}">
                    <span class="flex items-center">
                        <iconify-icon class=" nav-icon" icon="heroicons-outline:arrow-uturn-down"></iconify-icon>
                        <span>Pengembalian</span>
                    </span>
                </a>
            </li>

            <li class="sidebar-menu-title">Main</li>

            <li class="">
                <a href="{{ route('admin.author.index') }}"
                    class="navItem {{ $route == 'admin.author.index' ? 'active' : '' }}">
                    <span class="flex items-center">
                        <iconify-icon class=" nav-icon" icon="heroicons-outline:user"></iconify-icon>
                        <span>Author</span>
                    </span>
                </a>
            </li>
            <li class="">
                <a href="{{ route('admin.book.index') }}"
                    class="navItem {{ $route == 'admin.book.index' ? 'active' : '' }}">
                    <span class="flex items-center">
                        <iconify-icon class=" nav-icon" icon="heroicons-outline:book-open"></iconify-icon>
                        <span>Book</span>
                    </span>
                </a>
            </li>

            <li class="">
                <a href="{{ route('admin.member.index') }}"
                    class="navItem {{ $route == 'admin.member.index' ? 'active' : '' }}">
                    <span class="flex items-center">
                        <iconify-icon class=" nav-icon" icon="heroicons-outline:users"></iconify-icon>
                        <span>Member</span>
                    </span>
                </a>
            </li>
            <li class="">
                <a href="{{ route('admin.user.index') }}"
                    class="navItem {{ $route == 'admin.user.index' ? 'active' : '' }}">
                    <span class="flex items-center">
                        <iconify-icon class=" nav-icon" icon="heroicons-outline:users"></iconify-icon>
                        <span>User</span>
                    </span>
                </a>
            </li>
        </ul>
    </div>
</div>
<!-- End: Sidebar -->
