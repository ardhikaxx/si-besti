<aside class="sidebar bg-white shadow" id="sidebar">
    <div class="sidebar-header d-flex align-items-center justify-content-between p-4 border-bottom">
        <div class="d-flex align-items-center">
            <div class="sidebar-logo me-3 d-flex align-items-center justify-content-center"
                style="width: 40px; height: 40px; background: var(--gradient-primary); border-radius: var(--border-radius-sm);">
                <i class="fas fa-gem text-white"></i>
            </div>
            <div>
                <h5 class="mb-0 fw-bold" style="color: var(--primary);">SI-BESTI</h5>
                <small class="text-muted">Sistem Informasi</small>
            </div>
        </div>
        <button class="btn btn-sm btn-light d-lg-none" onclick="toggleSidebar()">
            <i class="fas fa-times"></i>
        </button>
    </div>
    <div class="sidebar-content p-3">
        <!-- Navigation Menu -->
        <nav class="sidebar-menu">
            <ul class="nav flex-column">
                <li class="nav-item mb-2">
                    <a class="nav-link d-flex align-items-center py-3 px-3 rounded-3 {{ request()->routeIs('admin.data-ibu*') ? 'active' : '' }}"
                        href="{{ route('admin.data-ibu') }}"
                        @if (request()->routeIs('admin.data-ibu*')) style="background: var(--gradient-primary); color: white;" @endif>
                        <i class="fas fa-users me-3"
                            style="color: {{ request()->routeIs('admin.data-ibu*') ? 'white' : 'var(--primary)' }} !important;"></i>
                        <span>Data Ibu Hamil</span>
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link d-flex align-items-center py-3 px-3 rounded-3 {{ request()->routeIs('admin.test-quality*') ? 'active' : '' }}"
                        href="{{ route('admin.test-quality.index') }}"
                        @if (request()->routeIs('admin.test-quality*')) style="background: var(--gradient-primary); color: white;" @endif>
                        <i class="fas fa-file-medical-alt me-3"
                            style="color: {{ request()->routeIs('admin.test-quality*') ? 'white' : 'var(--primary)' }} !important;"></i>
                        <span>Test Kualitas Tidur</span>
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link d-flex align-items-center py-3 px-3 rounded-3 {{ request()->routeIs('admin.sleep-tracking*') ? 'active' : '' }}"
                        href="{{ route('admin.sleep-tracking') }}"
                        @if (request()->routeIs('admin.sleep-tracking*')) style="background: var(--gradient-primary); color: white;" @endif>
                        <i class="fas fa-bed me-3"
                            style="color: {{ request()->routeIs('admin.sleep-tracking*') ? 'white' : 'var(--primary)' }} !important;"></i>
                        <span>Sleep Tracking</span>
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link d-flex align-items-center py-3 px-3 rounded-3 {{ request()->routeIs('admin.profile*') ? 'active' : '' }}"
                        href="{{ route('admin.profile') }}"
                        @if (request()->routeIs('admin.profile*')) style="background: var(--gradient-primary); color: white;" @endif>
                        <i class="fas fa-user-circle me-3"
                            style="color: {{ request()->routeIs('admin.profile*') ? 'white' : 'var(--primary)' }} !important;"></i>
                        <span>Profil Admin</span>
                    </a>
                </li>
            </ul>
            <!-- Bottom Menu -->
            <div class="sidebar-bottom mt-3 pt-2 border-top">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <form id="sidebar-logout-form" action="{{ route('admin.logout') }}" method="POST"
                            class="d-none">
                            @csrf
                        </form>
                        <a class="nav-link d-flex align-items-center py-3 px-3 rounded-3 text-danger" href="#"
                            onclick="logoutAdmin(event)">
                            <i class="fas fa-sign-out-alt me-3"></i>
                            <span>Keluar</span>
                        </a>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
</aside>
<style>
    .sidebar {
        position: fixed;
        top: 0;
        left: 0;
        width: 250px;
        height: 100vh;
        z-index: 1050;
        overflow-y: auto;
        transition: var(--transition);
    }

    .sidebar .nav-link {
        color: var(--secondary);
        transition: var(--transition);
    }

    .sidebar .nav-link:hover:not(.active) {
        background-color: var(--primary-lighter);
        color: var(--primary);
    }

    .sidebar .nav-link.active {
        background: var(--gradient-primary) !important;
        color: white !important;
        box-shadow: var(--shadow-sm);
    }

    .sidebar .nav-link.active i {
        color: white !important;
    }

    /* Mobile styles */
    @media (max-width: 992px) {
        .sidebar {
            transform: translateX(-100%);
            box-shadow: var(--shadow-lg);
        }

        .sidebar.active {
            transform: translateX(0);
        }

        .sidebar.active+.main-content.sidebar-active::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 1040;
        }
    }
</style>
