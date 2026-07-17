
<aside class="admin-sidebar" id="adminSidebar" aria-label="Main navigation">
    <div class="sidebar-header">
      <a class="brand-mark" href="index.html" aria-label="adminHMD dashboard">
        <span class="brand-icon"><i class="bi bi-grid-1x2-fill" aria-hidden="true"></i></span>
        <span class="brand-copy">
          <span class="brand-title">CRM</span>
          {{-- <span class="brand-subtitle">Admin Template</span> --}}
        </span>
      </a>
    </div>

    <nav class="sidebar-nav">
      <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}" aria-current="page">
        <span class="nav-icon"><i class="bi bi-speedometer2" aria-hidden="true"></i></span>
        <span class="nav-text">Dashboard</span>
      </a>
      <a class="nav-link {{ request()->routeIs('call-log') ? 'active' : '' }}" href="{{ route('call-log') }}">
        <span class="nav-icon"><i class="bi bi-people" aria-hidden="true"></i></span>
        <span class="nav-text">Call Log</span>
      </a>
      <li class="cu-menu-item">
            <a href="#" class="cu-menu-toggle">
                <span class="nav-icon"><i class="bi bi-box2-fill" aria-hidden="true"></i></span>
                <span class="nav-text">Master</span>
                <i class="bi bi-chevron-down cu-arrow"></i>
            </a>

            <ul class="cu-submenu">
                <li><a href="{{ route('company-master') }}">Add Product</a></li>
            </ul>
            <ul class="cu-submenu">
              <li><a href="{{ route('clients') }}">Add Client</a></li>
          </ul>
        </li>
    </nav>

    {{-- <div class="sidebar-user">
      <img class="avatar-img avatar-md sidebar-user-avatar" src="{{ asset('assets/images/avatar/profile.png') }}" alt="Admin">
      <strong>Admin11 Hasan</strong>
      <small>Active Workspace</small>
    </div> --}}

    {{-- <div class="sidebar-footer">
      <span class="status-dot"></span>
      <span class="sidebar-footer-text">System running smoothly1</span>
    </div> --}}
  </aside>