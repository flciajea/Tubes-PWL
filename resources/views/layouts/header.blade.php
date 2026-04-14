<div class="main-header">
  <div class="main-header-logo">
    <!-- Logo Header -->
    <div class="logo-header" data-background-color="dark">
      <a href="#" class="logo">
        <img
          src="{{ asset('assets/img/kaiadmin/logo_light.svg') }}"
          alt="navbar brand"
          class="navbar-brand"
          height="20"
        />
      </a>
      <div class="nav-toggle">
        <button class="btn btn-toggle toggle-sidebar">
          <i class="gg-menu-right"></i>
        </button>
        <button class="btn btn-toggle sidenav-toggler">
          <i class="gg-menu-left"></i>
        </button>
      </div>
    </div>
    <!-- End Logo Header -->
  </div>

  <!-- Navbar -->
  <nav class="navbar navbar-header navbar-expand-lg border-bottom">
    <div class="container-fluid">


      <!-- RIGHT MENU -->
      <ul class="navbar-nav ms-auto align-items-center">

        <!-- USER PROFILE -->
        <li class="nav-item">
          <a
            href="#"
            class="d-flex align-items-center"
            data-bs-toggle="modal"
            data-bs-target="#userModal"
          >
            <div class="avatar-sm me-2">
              <img
                src="{{ asset('assets/img/profile.jpg') }}"
                class="rounded-circle"
                width="35"
              >
            </div>
            <span>
              <span class="text-muted">Hi,</span>
              <strong>{{ Auth::user()->name }}</strong>
            </span>
          </a>
        </li>

      </ul>
    </div>
  </nav>
  <!-- End Navbar -->
</div>


<!-- ===================== -->
<!-- MODAL USER -->
<!-- ===================== -->
<div class="modal fade" id="userModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title">User Info</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body text-center">

        <img
          src="{{ asset('assets/img/profile.jpg') }}"
          class="rounded-circle mb-3"
          width="80"
        >

        <h5>{{ Auth::user()->name }}</h5>
        <p class="text-muted">{{ Auth::user()->email }}</p>

      </div>

      <div class="modal-footer d-flex justify-content-between">

        <button class="btn btn-secondary" data-bs-dismiss="modal">
          Tutup
        </button>

        <form method="POST" action="/logout">
          @csrf
          <button class="btn btn-danger">
            Logout
          </button>
        </form>

      </div>

    </div>
  </div>
</div>