<style>
.nav-wrap {
    background: white;
    border-bottom: 1px solid #e5e7eb;
    box-shadow: 0 2px 10px rgba(0,0,0,0.08);
    position: sticky;
    top: 0;
    z-index: 50;
}
.nav-inner {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 1rem;
    height: 60px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 0.5rem;
}
.nav-logo {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    text-decoration: none;
    flex: 1;
    min-width: 0;
}
.nav-logo-icon {
    background: linear-gradient(135deg, #f97316, #ea580c);
    padding: 0.4rem;
    border-radius: 9px;
    flex-shrink: 0;
}
.nav-logo-text {
    font-size: 0.95rem;
    font-weight: 700;
    color: #1f2937;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
@media (max-width: 400px) {
    .nav-logo-text { display: none; }
}
.nav-user-btn {
    display: flex;
    align-items: center;
    gap: 0.4rem;
    padding: 0.35rem 0.65rem;
    border-radius: 10px;
    background: #f9fafb;
    border: 1px solid #e5e7eb;
    cursor: pointer;
    font-family: inherit;
    flex-shrink: 0;
    min-height: 40px;
}
.nav-avatar {
    width: 28px;
    height: 28px;
    border-radius: 50%;
    background: linear-gradient(135deg, #f97316, #ea580c);
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    font-size: 0.78rem;
    flex-shrink: 0;
}
.nav-username {
    font-size: 0.85rem;
    font-weight: 500;
    color: #374151;
    max-width: 70px;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}
.nav-chevron {
    color: #9ca3af;
    flex-shrink: 0;
    transition: transform 0.2s;
}
/* Overlay gelap menutup seluruh layar */
.dropdown-overlay {
    display: none;
    position: fixed;
    inset: 0;
    z-index: 998;
    background: rgba(0,0,0,0.3);
}
.dropdown-overlay.active { display: block; }
/* Dropdown menu */
.dropdown-menu {
    display: none;
    position: absolute;
    right: 1rem;
    top: 68px;
    background: white;
    border: 1px solid #e5e7eb;
    border-radius: 12px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.18);
    min-width: 200px;
    overflow: hidden;
    z-index: 999;
}
.dropdown-menu.active { display: block; }
.dropdown-user-info {
    padding: 0.85rem 1rem;
    border-bottom: 1px solid #f3f4f6;
    background: #fafafa;
}
.dropdown-user-name { font-weight: 700; color: #1f2937; font-size: 0.9rem; }
.dropdown-user-email { color: #9ca3af; font-size: 0.75rem; margin-top: 0.1rem; }
.dropdown-item {
    display: flex;
    align-items: center;
    gap: 0.65rem;
    padding: 0.8rem 1rem;
    color: #374151;
    text-decoration: none;
    font-size: 0.9rem;
    transition: background 0.15s;
    width: 100%;
    background: white;
    border: none;
    cursor: pointer;
    font-family: inherit;
    text-align: left;
}
.dropdown-item:hover { background: #f9fafb; }
.dropdown-item.danger { color: #ef4444; }
.dropdown-item.danger:hover { background: #fef2f2; }
.dropdown-divider { border: none; border-top: 1px solid #f3f4f6; }
</style>

<nav class="nav-wrap">
    <div class="nav-inner">
        <!-- Logo -->
        <a href="{{ route('dashboard') }}" class="nav-logo">
            <div class="nav-logo-icon">
                <svg width="22" height="22" fill="none" stroke="white" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
            </div>
            <span class="nav-logo-text">Sistem Toko Sembako</span>
        </a>

        <!-- User Button -->
        <button class="nav-user-btn" id="userBtn" onclick="toggleDropdown()">
            <div class="nav-avatar">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</div>
            <span class="nav-username">{{ Auth::user()->name }}</span>
            <svg class="nav-chevron" id="navChevron" width="12" height="12" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>
            </svg>
        </button>
    </div>
</nav>

<!-- Overlay (klik untuk tutup) -->
<div class="dropdown-overlay" id="dropdownOverlay" onclick="closeDropdown()"></div>

<!-- Dropdown Menu (di luar nav agar tidak terpotong) -->
<div class="dropdown-menu" id="dropdownMenu">
    <div class="dropdown-user-info">
        <div class="dropdown-user-name">{{ Auth::user()->name }}</div>
        <div class="dropdown-user-email">{{ Auth::user()->email }}</div>
    </div>

    <a href="{{ route('profile.edit') }}" class="dropdown-item" onclick="closeDropdown()">
        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
        </svg>
        Profile
    </a>

    <div class="dropdown-divider"></div>

    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="dropdown-item danger">
            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
            </svg>
            Log Out
        </button>
    </form>
</div>

<script>
function toggleDropdown() {
    const menu    = document.getElementById('dropdownMenu');
    const overlay = document.getElementById('dropdownOverlay');
    const chevron = document.getElementById('navChevron');
    const isOpen  = menu.classList.contains('active');

    if (isOpen) {
        closeDropdown();
    } else {
        menu.classList.add('active');
        overlay.classList.add('active');
        chevron.style.transform = 'rotate(180deg)';
    }
}

function closeDropdown() {
    const menu    = document.getElementById('dropdownMenu');
    const overlay = document.getElementById('dropdownOverlay');
    const chevron = document.getElementById('navChevron');
    menu.classList.remove('active');
    overlay.classList.remove('active');
    chevron.style.transform = 'rotate(0deg)';
}

// Tutup juga saat tekan Escape
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') closeDropdown();
});
</script>
