<header class="header fixed-top">
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm py-2 px-3">
        <div class="container-fluid">
            <!-- Sidebar Toggler for Mobile -->
            <button class="sidebar-toggler" type="button" onclick="toggleSidebar()">
                <i class="fas fa-bars"></i>
            </button>

            <!-- Brand/Logo -->
            <a class="navbar-brand d-flex align-items-center" href="#">
                <div class="brand-icon me-2 d-flex align-items-center justify-content-center"
                    style="width: 40px; height: 40px; background: var(--gradient-primary); border-radius: var(--border-radius-sm);">
                    <i class="fas fa-user-shield text-white"></i>
                </div>
                <span class="fw-bold" style="color: var(--primary);">SI-BESTI</span>
            </a>

            <!-- Right Side Menu -->
            <div class="d-flex align-items-center ms-auto">
                <!-- User Profile Dropdown -->
                <div class="dropdown">
                    <button class="btn d-flex align-items-center p-0 border-0" type="button" id="userDropdown"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        <div class="d-flex align-items-center">
                            @php
                                $admin = Auth::guard('admin')->user();
                                $namaAdmin = $admin ? $admin->nama_lengkap : 'Admin';
                                $namaSingkat = $admin ? substr($admin->nama_lengkap, 0, 1) . substr($admin->nama_lengkap, strpos($admin->nama_lengkap, ' ') + 1, 1) : 'AB';
                            @endphp
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($namaAdmin) }}&background=0856C8&color=fff&size=128"
                                alt="Admin Avatar" class="avatar me-2">
                            <div class="d-none d-md-block text-start">
                                <div class="fw-bold small">{{ $namaAdmin }}</div>
                            </div>
                            <i class="fas fa-chevron-down ms-1 text-secondary"></i>
                        </div>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end shadow border-0" aria-labelledby="userDropdown">
                        <li>
                            <a class="dropdown-item d-flex align-items-center mt-2" href="{{ route('admin.profile') }}">
                                <i class="fas fa-user-circle me-2 text-primary"></i>
                                <span>Profil Saya</span>
                            </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                            <a class="dropdown-item d-flex align-items-center text-danger" href="#" onclick="logoutAdmin(event)">
                                <i class="fas fa-sign-out-alt me-2"></i>
                                <span>Keluar</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
</header>