<nav x-data="{ open: false }" style="background:white; border-bottom:1px solid #e5e7eb; box-shadow:0 2px 10px rgba(0,0,0,0.08); position:sticky; top:0; z-index:50;">
    <div style="max-width:1200px; margin:0 auto; padding:0 1.5rem; position:relative; display:flex; align-items:center; justify-content:space-between; height:64px;">

        <!-- Spacer kiri (kosong, biar logo bisa tengah) -->
        <div style="width:160px;"></div>

        <!-- Logo + Judul TENGAH -->
        <a href="{{ route('dashboard') }}" style="position:absolute; left:50%; transform:translateX(-50%); display:flex; align-items:center; gap:0.75rem; text-decoration:none;">
            <div style="background:linear-gradient(135deg,#f97316,#ea580c); padding:0.5rem; border-radius:10px;">
                <svg width="26" height="26" fill="none" stroke="white" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
            </div>
            <span style="font-size:1.1rem; font-weight:700; color:#1f2937; white-space:nowrap;">Sistem Toko Sembako</span>
        </a>

        <!-- User Dropdown KANAN -->
        <div style="position:relative;" x-data="{ dropdownOpen: false }">
            <!-- Trigger Button -->
            <button 
                @click="dropdownOpen = !dropdownOpen"
                style="display:flex; align-items:center; gap:0.6rem; padding:0.4rem 1rem; border-radius:10px; background:#f9fafb; border:1px solid #e5e7eb; cursor:pointer; font-family:inherit;">
                <div style="width:32px; height:32px; border-radius:50%; background:linear-gradient(135deg,#f97316,#ea580c); color:white; display:flex; align-items:center; justify-content:center; font-weight:700; font-size:0.85rem; flex-shrink:0;">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>
                <span style="font-size:0.9rem; font-weight:500; color:#374151;">{{ Auth::user()->name }}</span>
                <svg width="14" height="14" fill="currentColor" style="color:#9ca3af;" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>
                </svg>
            </button>

            <!-- Dropdown Menu -->
            <div 
                x-show="dropdownOpen"
                @click.outside="dropdownOpen = false"
                x-transition
                style="position:absolute; right:0; top:calc(100% + 8px); background:white; border:1px solid #e5e7eb; border-radius:10px; box-shadow:0 8px 25px rgba(0,0,0,0.12); min-width:180px; overflow:hidden; z-index:100;">
                
                <a href="{{ route('profile.edit') }}" 
                   style="display:flex; align-items:center; gap:0.6rem; padding:0.75rem 1rem; color:#374151; text-decoration:none; font-size:0.9rem; transition:background 0.15s;"
                   onmouseover="this.style.background='#f9fafb'"
                   onmouseout="this.style.background='white'">
                    <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                    Profile
                </a>

                <div style="border-top:1px solid #f3f4f6;"></div>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        style="display:flex; align-items:center; gap:0.6rem; width:100%; padding:0.75rem 1rem; color:#ef4444; background:white; border:none; cursor:pointer; font-size:0.9rem; text-align:left; font-family:inherit; transition:background 0.15s;"
                        onmouseover="this.style.background='#fef2f2'"
                        onmouseout="this.style.background='white'">
                        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                        </svg>
                        Log Out
                    </button>
                </form>
            </div>
        </div>

    </div>
</nav>
