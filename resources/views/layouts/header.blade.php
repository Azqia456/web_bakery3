<header class="header">
    <div class="header-left">
        <h1 class="header-title">{{ $title ?? 'Dashboard' }}</h1>
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

        <button class="notification-btn" title="Notifikasi">
            <i class="fas fa-bell"></i>
            <span class="notification-badge">{{ $totalNotifikasi ?? 0 }}</span>
        </button>

        <div class="profile-menu">
            <button type="button" class="profile-btn" id="profileMenuButton" aria-haspopup="true" aria-expanded="false" title="Akun">
                <img 
                    src="{{ auth()->user()->foto_profil ? asset('storage/' . auth()->user()->foto_profil) : 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->username) . '&background=8B6F47&color=fff&size=32' }}" 
                    alt="Avatar" 
                    class="profile-avatar-img"
                    style="width: 35px; height: 35px; border-radius: 50%; object-fit: cover;"
                >
            </button>

            <div class="profile-dropdown" id="profileDropdown">
                <a href="{{ route('profile.edit') ?? '#' }}">
                    <i class="fas fa-user"></i>
                    Profil
                </a>
                <form action="{{ route('logout') ?? '#' }}" method="POST">
                    @csrf
                    <button type="submit" class="logout-action">
                        <i class="fas fa-right-from-bracket"></i>
                        Logout
                    </button>
                </form>     
            </div>
        </div>  
    </div>
</header>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const profileMenuButton = document.getElementById('profileMenuButton');
        const profileDropdown = document.getElementById('profileDropdown');

        if (profileMenuButton && profileDropdown) {
            const closeProfileDropdown = () => {
                profileDropdown.classList.remove('show');
                profileMenuButton.setAttribute('aria-expanded', 'false');
            };

            profileMenuButton.addEventListener('click', function(event) {
                event.stopPropagation();
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
    });
</script>