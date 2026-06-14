<header class="header">
    <div class="header-left">
        <h1 class="header-title">{{ $title ?? ($pageTitle ?? 'Dashboard') }}</h1>
    </div>

    @if(isset($showSearch) && $showSearch)
        <div class="search-bar">
            <i class="fas fa-search"></i>
            <input type="text" placeholder="Cari pesanan, pelanggan, produk...">
        </div>
    @endif

    <div class="header-right">
        @if(isset($showAddButton) && $showAddButton)
            <button class="btn-primary" onclick="openAddModal()">
                <i class="fas fa-plus"></i>
                Tambah Pesanan
            </button>
        @endif

        <!-- Notification Button -->
        <div class="notification-menu">
            {{-- <button type="button" class="notification-btn" id="notificationMenuButton" aria-haspopup="true" aria-expanded="false" title="Notifikasi">
                <i class="fas fa-bell"></i>
                <span class="notification-badge">{{ $totalNotifikasi ?? 0 }}</span>
            </button> --}}

            <!-- Notification Dropdown -->
            <div class="notification-dropdown" id="notificationDropdown">
                <div class="dropdown-header">
                    <span class="dropdown-title">Notifikasi</span>
                    <span class="dropdown-badge">{{ $totalNotifikasi ?? 0 }} baru</span>
                </div>
                <div class="dropdown-divider"></div>
                <div class="notification-list">
                    <div class="notification-item">
                        <div class="notification-icon bg-blue">
                            <i class="fas fa-shopping-bag"></i>
                        </div>
                        <div class="notification-content">
                            <p class="notification-text">Pesanan baru masuk dari <strong>Rina Amelia</strong></p>
                            <span class="notification-time">2 menit yang lalu</span>
                        </div>
                    </div>
                    <div class="notification-item">
                        <div class="notification-icon bg-orange">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div class="notification-content">
                            <p class="notification-text">Pesanan <strong>#ON-040626-001</strong> menunggu konfirmasi</p>
                            <span class="notification-time">15 menit yang lalu</span>
                        </div>
                    </div>
                    <div class="notification-item">
                        <div class="notification-icon bg-green">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <div class="notification-content">
                            <p class="notification-text">Pesanan <strong>#ON-040626-003</strong> telah selesai</p>
                            <span class="notification-time">1 jam yang lalu</span>
                        </div>
                    </div>
                </div>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-footer">
                    Lihat semua notifikasi
                </a>
            </div>
        </div>

        <!-- Profile Button -->
        <div class="profile-menu">
            <button type="button" class="profile-btn" id="profileMenuButton" aria-haspopup="true" aria-expanded="false" title="Akun">
                <img 
                    src="{{ auth()->user()->foto_profil ? asset('storage/' . auth()->user()->foto_profil) : 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->username) . '&background=8B6F47&color=fff&size=32' }}" 
                    alt="Avatar" 
                    class="profile-avatar-img"
                >
            </button>

            <!-- Profile Dropdown -->
            <div class="profile-dropdown" id="profileDropdown">
                <div class="dropdown-header">
                    <img 
                        src="{{ auth()->user()->foto_profil ? asset('storage/' . auth()->user()->foto_profil) : 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->username) . '&background=8B6F47&color=fff&size=40' }}" 
                        alt="Avatar" 
                        class="dropdown-avatar"
                    >
                    <div class="dropdown-user-info">
                        <span class="dropdown-user-name">{{ auth()->user()->username ?? 'User' }}</span>
                        <span class="dropdown-user-role">{{ auth()->user()->role ?? 'Owner' }}</span>
                    </div>
                </div>
                <div class="dropdown-divider"></div>
                <a href="{{ route('profile.edit') ?? '#' }}" class="dropdown-item">
                    <i class="fas fa-user"></i>
                    <span>Profil</span>
                </a>
                <a href="#" class="dropdown-item" onclick="document.getElementById('notificationMenuButton').click(); return false;">
                    <i class="fas fa-bell"></i>
                    <span>Notifikasi</span>
                    @if(($totalNotifikasi ?? 0) > 0)
                        <span class="dropdown-item-badge">{{ $totalNotifikasi ?? 0 }}</span>
                    @endif
                </a>
                <div class="dropdown-divider"></div>
                <form action="{{ route('logout') ?? '#' }}" method="POST" class="dropdown-form">
                    @csrf
                    <button type="submit" class="dropdown-item logout-action">
                        <i class="fas fa-right-from-bracket"></i>
                        <span>Logout</span>
                    </button>
                </form>     
            </div>
        </div>  
    </div>
</header>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Profile Dropdown
        const profileMenuButton = document.getElementById('profileMenuButton');
        const profileDropdown = document.getElementById('profileDropdown');
        const notificationMenuButton = document.getElementById('notificationMenuButton');
        const notificationDropdown = document.getElementById('notificationDropdown');

        if (profileMenuButton && profileDropdown) {
            const closeProfileDropdown = () => {
                profileDropdown.classList.remove('show');
                profileMenuButton.setAttribute('aria-expanded', 'false');
            };

            profileMenuButton.addEventListener('click', function(event) {
                event.stopPropagation();
                // Close notification dropdown if open
                if (notificationDropdown) notificationDropdown.classList.remove('show');
                
                const isOpen = profileDropdown.classList.toggle('show');
                profileMenuButton.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
            });

            profileDropdown.addEventListener('click', function(event) {
                event.stopPropagation();
            });

            document.addEventListener('click', closeProfileDropdown);
            document.addEventListener('keydown', function(event) {
                if (event.key === 'Escape') {
                    closeProfileDropdown();
                }
            });
        }

        // Notification Dropdown
        if (notificationMenuButton && notificationDropdown) {
            const closeNotificationDropdown = () => {
                notificationDropdown.classList.remove('show');
                notificationMenuButton.setAttribute('aria-expanded', 'false');
            };

            notificationMenuButton.addEventListener('click', function(event) {
                event.stopPropagation();
                // Close profile dropdown if open
                if (profileDropdown) profileDropdown.classList.remove('show');
                
                const isOpen = notificationDropdown.classList.toggle('show');
                notificationMenuButton.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
            });

            notificationDropdown.addEventListener('click', function(event) {
                event.stopPropagation();
            });

            document.addEventListener('click', function(event) {
                const notificationMenu = document.querySelector('.notification-menu');
                if (notificationMenu && !notificationMenu.contains(event.target)) {
                    closeNotificationDropdown();
                }
            });
            document.addEventListener('keydown', function(event) {
                if (event.key === 'Escape') {
                    closeNotificationDropdown();
                }
            });
        }
    });
</script>
