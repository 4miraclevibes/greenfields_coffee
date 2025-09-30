        <!-- Menu -->

        <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
            <div class="app-brand demo m-0 border-bottom">
              <a href="#" class="app-brand-link">
                <span class="app-brand-logo demo">
                  <img src="https://greenfields-professional.com/img/logo.png" style="max-width: 150px" alt="">
                </span>
              </a>

              <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
                <i class="bx bx-chevron-left bx-sm align-middle"></i>
              </a>
            </div>

            <div class="menu-inner-shadow"></div>

            <ul class="menu-inner py-1 mt-3">
              <!-- Dashboard -->
              <li class="menu-item {{ Route::is('dashboard') ? 'active' : '' }}">
                <a href="{{ route('dashboard') }}" class="menu-link">
                  <i class="menu-icon tf-icons bx bxs-home"></i>
                  <div data-i18n="Dashboard">Dashboard</div>
                </a>
              </li>

              <!-- Users -->
              <li class="menu-item {{ Route::is('users*') ? 'active' : '' }}">
                <a href="{{ route('users.index') }}" class="menu-link">
                  <i class="menu-icon tf-icons bx bxs-user"></i>
                  <div data-i18n="Users">Users</div>
                </a>
              </li>

              <!-- Menus -->
              <li class="menu-item {{ Route::is('menus*') ? 'active' : '' }}">
                <a href="{{ route('menus.index') }}" class="menu-link">
                  <i class="menu-icon tf-icons bx bxs-coffee"></i>
                  <div data-i18n="Menus">Menus</div>
                </a>
              </li>

              <!-- Rooms -->
              <li class="menu-item {{ Route::is('rooms*') ? 'active' : '' }}">
                <a href="{{ route('rooms.index') }}" class="menu-link">
                  <i class="menu-icon tf-icons bx bxs-building"></i>
                  <div data-i18n="Rooms">Rooms</div>
                </a>
              </li>

              <!-- Transactions -->
              <li class="menu-item {{ Route::is('transactions*') ? 'active' : '' }}">
                <a href="{{ route('transactions.index') }}" class="menu-link">
                  <i class="menu-icon tf-icons bx bxs-receipt"></i>
                  <div data-i18n="Transactions">Transactions</div>
                </a>
              </li>
            </ul>
          </aside>
          <!-- / Menu -->
