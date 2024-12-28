<ul class="menu-inner py-1">
    <!-- Dashboard -->

      <li class="menu-item {{ str_contains(url()->current(), 'admin/dashboard') ? 'active' : '' }}">
        <a href="{{ url('admin/dashboard') }}" class="menu-link">
          <i class="menu-icon tf-icons bx bx-home-circle"></i>
          <div data-i18n="Analytics">Dashboard</div>
        </a>
      </li>
      <li class="menu-item {{ str_contains(url()->current(), 'admin/blogs') ? 'active' : '' }}">
        <a href="{{ route('admin.blogs.index') }}" class="menu-link">
          <i class='menu-icon tf-icons bx bxs-book-content'></i>
          <div data-i18n="Analytics">Blogs</div>
        </a>
      </li>

    <li class="menu-item">
      <a href="{{route('admin.logout')}}" class="menu-link">
        <i class="menu-icon tf-icons bx bx-power-off"></i>
        <div data-i18n="Analytics">Logout</div>
      </a>
    </li>
  </ul>