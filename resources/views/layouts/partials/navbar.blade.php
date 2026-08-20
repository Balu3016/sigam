<!-- Navbar / Barra Superior -->
<nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom shadow-sm sticky-top" style="margin-left: 260px; transition: all 0.3s ease;" id="main-navbar">
    <div class="container-fluid px-4">
        <!-- Toggle Button para Sidebar Móvil/Escritorio -->
        <button class="btn btn-sm btn-outline-secondary me-3" type="button" id="sidebarToggle">
            <i class="bi bi-list fs-5"></i>
        </button>

        <!-- Título Institucional de la Cabecera -->
        <span class="navbar-brand mb-0 h1 fs-6 fw-bold text-dark text-uppercase d-none d-sm-inline-block">
            Sistema Integral de Gestión de Apoyos Municipales
        </span>

        <!-- Dropdown Usuario -->
        <div class="ms-auto d-flex align-items-center">
            <div class="dropdown">
                <button class="btn btn-light dropdown-toggle d-flex align-items-center gap-2 border shadow-sm px-3 py-1 rounded-pill" type="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    <!-- Badge con Inicial -->
                    <div class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center fw-bold" style="width: 32px; height: 32px; font-size: 0.85rem;">
                        {{ strtoupper(substr(Auth::user()->name ?? 'U', 0, 1)) }}
                    </div>
                    <span class="fw-semibold text-dark fs-7 d-none d-md-inline">{{ Auth::user()->name ?? 'Usuario' }}</span>
                </button>
                <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0 mt-2" aria-labelledby="userDropdown">
                    <li class="dropdown-header border-bottom pb-2">
                        <span class="d-block fw-bold text-dark">{{ Auth::user()->name ?? 'Usuario' }}</span>
                        <small class="text-muted d-block text-truncate" style="max-width: 180px;">{{ Auth::user()->email ?? '' }}</small>
                    </li>
                    <li>
                        <a class="dropdown-item d-flex align-items-center gap-2 py-2 mt-1" href="{{ route('profile.edit') }}">
                            <i class="bi bi-person-gear text-warning"></i> Mi Perfil
                        </a>
                    </li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="dropdown-item d-flex align-items-center gap-2 py-2 text-danger">
                                <i class="bi bi-box-arrow-right"></i> Cerrar Sesión
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>