<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="{{ route('dashboard') }}">{{ $appName }}</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="{{ route('dashboard') }}">SP</a>
        </div>
        <ul class="sidebar-menu">
            {{-- Menu Semua User --}}
            <li class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('dashboard') }}">
                    <i class="fas fa-tachometer-alt"></i> <span>Dashboard</span>
                </a>
            </li>

            {{-- Menu ADMIN --}}
            @if (auth()->user()->role == 'admin')
                <li class="menu-header">Admin</li>
                <li class="{{ request()->is('users*') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('users.index') }}">
                        <i class="fas fa-users"></i> <span>Manajemen User</span>
                    </a>
                </li>
                <li class="{{ request()->is('violation-types*') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('violation-types.index') }}">
                        <i class="fas fa-book"></i> <span>Jenis Pelanggaran</span>
                    </a>
                </li>
                <li class="{{ request()->is('penalty-levels*') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('penalty-levels.index') }}">
                        <i class="fas fa-level-up-alt"></i> <span>Tingkat Sanksi</span>
                    </a>
                </li>
                <li class="{{ request()->is('system-settings*') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('system-settings.index') }}">
                        <i class="fas fa-cogs"></i> <span>Pengaturan Sistem</span>
                    </a>
                </li>
            @endif

            {{-- Menu KIA Member --}}
            @if (auth()->user()->role == 'kia_member')
                <li class="menu-header">KIA Member</li>
                <li class="{{ request()->is('reports*') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('reports.index') }}">
                        <i class="fas fa-clipboard-list"></i> <span>Validasi Laporan</span>
                    </a>
                </li>
                <li class="{{ request()->is('investigations*') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('investigations.index') }}">
                        <i class="fas fa-users-cog"></i> <span>Manajemen Investigasi</span>
                    </a>
                </li>
                <li class="{{ request()->is('penalties*') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('penalties.index') }}">
                        <i class="fas fa-gavel"></i> <span>Penetapan Sanksi</span>
                    </a>
                </li>
                <li class="{{ request()->is('committee-members*') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('committee-members.index') }}">
                        <i class="fas fa-user-shield"></i> <span>Anggota KIA</span>
                    </a>
                </li>
            @endif

            {{-- Menu Investigator --}}
            @if (auth()->user()->role == 'investigator')
                <li class="menu-header">Investigator</li>
                <li class="{{ request()->is('investigations*') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('investigations.index') }}">
                        <i class="fas fa-search"></i> <span>Daftar Investigasi</span>
                    </a>
                </li>
            @endif

            {{-- Menu Pelapor (Student, Lecturer, Staff, External) --}}
            @if (in_array(auth()->user()->role, ['student', 'lecturer', 'staff', 'external']))
                <li class="menu-header">Pelapor</li>
                <li class="{{ request()->is('reports*') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('reports.index') }}">
                        <i class="fas fa-clipboard"></i> <span>Laporan Saya</span>
                    </a>
                </li>
                <li class="{{ request()->is('appeals*') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('appeals.index') }}">
                        <i class="fas fa-bullhorn"></i> <span>Banding Saya</span>
                    </a>
                </li>
            @endif

            {{-- Menu Logout --}}
            <li>
                <a class="nav-link text-danger" href="{{ route('logout') }}"
                    onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt"></i> <span>Logout</span>
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </li>
        </ul>

        <div class="hide-sidebar-mini mt-4 mb-4 p-3">
            <a href="https://getstisla.com/docs" class="btn btn-primary btn-lg btn-block btn-icon-split">
                <i class="fas fa-rocket"></i> Documentation
            </a>
        </div>
    </aside>
</div>
