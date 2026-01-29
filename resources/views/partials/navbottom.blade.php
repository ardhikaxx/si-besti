@php
    $currentRoute = \Request::route()->getName();
    $menus = [
        [
            'route' => 'pengguna.dashboard',
            'icon' => 'fas fa-home',
            'label' => 'Beranda',
            'active' => strpos($currentRoute, 'dashboard') !== false,
        ],
        [
            'route' => 'pengguna.sleep-tracking.index',
            'icon' => 'fas fa-bed',
            'label' => 'Sleep Tracking',
            'active' => strpos($currentRoute, 'sleep') !== false,
        ],
        [
            'route' => 'pengguna.quality-test.index',
            'icon' => 'fas fa-file-signature',
            'label' => 'Test',
            'active' => strpos($currentRoute, 'test') !== false,
        ],
        [
            'route' => 'pengguna.murottal',
            'icon' => 'fas fa-hands-praying',
            'label' => 'Murottal',
            'active' => strpos($currentRoute, 'murottal') !== false,
        ],
        [
            'route' => 'pengguna.profile',
            'icon' => 'fas fa-user',
            'label' => 'Profil',
            'active' => strpos($currentRoute, 'profile') !== false,
        ],
    ];
@endphp

<nav class="floating-navbar">
    <div class="floating-nav-container">
        <div class="floating-nav">
            <div class="nav-backdrop"></div>
            <ul class="nav-menu">
                @foreach ($menus as $menu)
                    <li class="nav-item {{ $menu['active'] ? 'active' : '' }}">
                        <a href="{{ route($menu['route']) }}" class="nav-link">
                            <div class="nav-icon">
                                <i class="{{ $menu['icon'] }}"></i>
                            </div>
                            <span class="nav-label">{{ $menu['label'] }}</span>
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</nav>

<style>
    .floating-navbar {
        position: fixed;
        bottom: 0;
        left: 0;
        right: 0;
        z-index: 1000;
        padding: 0 15px 20px;
        pointer-events: none;
    }

    .floating-nav-container {
        position: relative;
        max-width: 500px;
        margin: 0 auto;
        pointer-events: auto;
    }

    .floating-nav {
        position: relative;
        background: var(--white);
        border-radius: 25px;
        box-shadow: var(--shadow-lg);
        padding: 15px 20px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        border: 1px solid var(--border-color);
    }

    .nav-backdrop {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(135deg, rgba(255, 255, 255, 0.9), rgba(248, 250, 252, 0.9));
        border-radius: 25px;
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
    }

    .nav-menu {
        display: flex;
        justify-content: space-around;
        align-items: center;
        width: 100%;
        list-style: none;
        margin: 0;
        padding: 0;
        position: relative;
        z-index: 1;
    }

    .nav-item {
        flex: 1;
        text-align: center;
        position: relative;
    }

    .nav-link {
        display: flex;
        flex-direction: column;
        align-items: center;
        text-decoration: none;
        padding: 8px 0;
        position: relative;
        transition: var(--transition);
        border-radius: 12px;
    }

    .nav-icon {
        width: 24px;
        height: 24px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 4px;
        transition: var(--transition);
    }

    .nav-icon i {
        font-size: 1.2rem;
        color: var(--secondary);
        transition: var(--transition);
    }

    .nav-label {
        font-size: 0.7rem;
        font-weight: 500;
        color: var(--secondary);
        transition: var(--transition);
        white-space: nowrap;
    }

    .nav-item.active .nav-icon i {
        color: var(--primary);
        font-size: 1.3rem;
    }

    .nav-item.active .nav-label {
        color: var(--primary);
        font-weight: 600;
    }

    .nav-link:hover .nav-icon i {
        color: var(--primary);
        transform: scale(1.1);
    }

    .nav-link:hover .nav-label {
        color: var(--primary);
    }

    /* Responsive Adjustments */
    @media (max-width: 768px) {
        .floating-navbar {
            padding: 0 10px 15px;
        }

        .floating-nav {
            padding: 12px 15px;
            border-radius: 20px;
        }

        .center-button {
            width: 55px;
            height: 55px;
            font-size: 1.3rem;
        }

        .nav-icon {
            width: 20px;
            height: 20px;
        }

        .nav-icon i {
            font-size: 1.1rem;
        }

        .nav-item.active .nav-icon i {
            font-size: 1.2rem;
        }

        .nav-label {
            font-size: 0.65rem;
        }

        .quick-action-menu {
            bottom: 90px;
        }

        .action-item {
            padding: 12px;
            min-width: 85px;
        }

        .action-icon {
            width: 35px;
            height: 35px;
        }

        .action-label {
            font-size: 0.7rem;
        }
    }

    @media (max-width: 480px) {
        .floating-navbar {
            padding: 0 5px 10px;
        }

        .floating-nav {
            padding: 10px 12px;
            border-radius: 18px;
        }

        .center-button {
            width: 50px;
            height: 50px;
            font-size: 1.2rem;
            border-width: 2px;
        }

        .nav-icon i {
            font-size: 1rem;
        }

        .nav-item.active .nav-icon i {
            font-size: 1.1rem;
        }

        .nav-label {
            font-size: 0.6rem;
        }

        .quick-action-menu {
            bottom: 85px;
        }

        .action-items {
            gap: 15px;
        }

        .action-item {
            padding: 10px;
            min-width: 75px;
        }

        .action-icon {
            width: 30px;
            height: 30px;
        }

        .action-label {
            font-size: 0.65rem;
        }
    }

    /* Desktop Adjustments */
    @media (min-width: 769px) {
        .floating-navbar {
            padding-bottom: 25px;
        }

        .floating-nav {
            border-radius: 30px;
            padding: 18px 25px;
        }

        .nav-icon i {
            font-size: 1.3rem;
        }

        .nav-item.active .nav-icon i {
            font-size: 1.4rem;
        }

        .nav-label {
            font-size: 0.8rem;
        }
    }

    /* Animation for menu items */
    .nav-item {
        animation: slideUp 0.5s ease forwards;
        opacity: 0;
    }

    .nav-item:nth-child(1) {
        animation-delay: 0.1s;
    }

    .nav-item:nth-child(2) {
        animation-delay: 0.2s;
    }

    .nav-item:nth-child(3) {
        animation-delay: 0.3s;
    }

    .nav-item:nth-child(4) {
        animation-delay: 0.4s;
    }

    .nav-item:nth-child(5) {
        animation-delay: 0.5s;
    }

    @keyframes slideUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const quickActionButton = document.getElementById('quickActionButton');
        const quickActionMenu = document.getElementById('quickActionMenu');
        const actionBackdrop = document.getElementById('actionBackdrop');

        // Toggle quick action menu
        quickActionButton.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();

            const isActive = quickActionMenu.classList.contains('active');

            if (isActive) {
                quickActionMenu.classList.remove('active');
                this.innerHTML = '<i class="fas fa-plus"></i>';
            } else {
                quickActionMenu.classList.add('active');
                this.innerHTML = '<i class="fas fa-times"></i>';
            }
        });

        // Close menu when clicking backdrop
        actionBackdrop.addEventListener('click', function() {
            quickActionMenu.classList.remove('active');
            quickActionButton.innerHTML = '<i class="fas fa-plus"></i>';
        });

        // Close menu when clicking outside
        document.addEventListener('click', function(e) {
            if (!quickActionMenu.contains(e.target) && !quickActionButton.contains(e.target)) {
                quickActionMenu.classList.remove('active');
                quickActionButton.innerHTML = '<i class="fas fa-plus"></i>';
            }
        });

        // Handle action item clicks
        document.querySelectorAll('.action-item').forEach(item => {
            item.addEventListener('click', function(e) {
                e.preventDefault();
                const action = this.getAttribute('data-action');

                // Handle different actions
                switch (action) {
                    case 'track-sleep':
                        window.location.href = "{{ route('pengguna.sleep-tracking.index') }}";
                        break;
                    case 'quick-test':
                        window.location.href = "{{ route('pengguna.quality-test.index') }}";
                        break;
                    case 'play-murottal':
                        window.location.href = "{{ route('pengguna.murottal') }}";
                        break;
                }

                // Close menu
                quickActionMenu.classList.remove('active');
                quickActionButton.innerHTML = '<i class="fas fa-plus"></i>';
            });
        });

        // Add ripple effect to center button
        quickActionButton.addEventListener('click', function(e) {
            const ripple = document.createElement('span');
            const rect = this.getBoundingClientRect();
            const size = Math.max(rect.width, rect.height);
            const x = e.clientX - rect.left - size / 2;
            const y = e.clientY - rect.top - size / 2;

            ripple.style.cssText = `
                position: absolute;
                border-radius: 50%;
                background: rgba(255, 255, 255, 0.7);
                transform: scale(0);
                animation: ripple-animation 0.6s linear;
                width: ${size}px;
                height: ${size}px;
                top: ${y}px;
                left: ${x}px;
                pointer-events: none;
                z-index: 1;
            `;

            this.appendChild(ripple);

            setTimeout(() => {
                ripple.remove();
            }, 600);
        });

        // Add hover effect to nav items
        document.querySelectorAll('.nav-link').forEach(link => {
            link.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-3px)';
            });

            link.addEventListener('mouseleave', function() {
                if (!this.closest('.nav-item').classList.contains('active')) {
                    this.style.transform = 'translateY(0)';
                }
            });
        });
    });

    // Add ripple animation style
    const style = document.createElement('style');
    style.textContent = `
        @keyframes ripple-animation {
            to {
                transform: scale(4);
                opacity: 0;
            }
        }
    `;
    document.head.appendChild(style);
</script>
