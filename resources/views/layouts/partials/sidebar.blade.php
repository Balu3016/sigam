<!-- Sidebar / Menú Lateral Institucional -->
<!-- Sidebar / Menú Lateral Institucional -->
<aside id="sidebar" class="bg-dark text-white vh-100 d-flex flex-column flex-shrink-0 p-3 position-fixed top-0 start-0 z-3 transition-all" style="width: 260px; transition: all 0.3s ease;">
    
    <!-- Marca & Identidad Institucional -->
    <a href="{{ route('dashboard') }}" class="d-flex items-center text-white text-decoration-none mb-3 mb-md-0 me-md-auto p-2 border-bottom border-secondary w-100 pb-3">
        <div class="bg-success rounded-3 p-2 me-2 d-flex align-items-center justify-content-center shadow-sm" style="width: 40px; height: 40px;">
            <i class="bi bi-shield-check text-warning fs-4"></i>
        </div>
        <div class="d-flex flex-column">
            <span class="fw-bold tracking-wide text-uppercase fs-6 leading-tight">OCOYOACAC</span>
            <span class="text-secondary text-uppercase font-monospace" style="font-size: 0.65rem;">Gobierno Municipal</span>
        </div>
    </a>

    <hr class="border-secondary my-2">

    <!-- Navegación Principal -->
    <ul class="nav nav-pills flex-column mb-auto gap-1">
        
        <!-- Dashboard -->
        <li class="nav-item">
            <a href="{{ route('dashboard') }}" class="nav-link text-white d-flex align-items-center gap-2 {{ request()->routeIs('dashboard') ? 'active bg-success' : 'hover-bg-dark-subtle' }}">
                <i class="bi bi-speedometer2"></i>
                <span>Panel Principal</span>
            </a>
        </li>

        <!-- ==================================================== -->
        <!-- SECCIÓN 1: CATÁLOGOS BASE (Creación Individual)      -->
        <!-- ==================================================== -->
        <li class="nav-header text-uppercase text-secondary font-monospace mt-3 mb-1 px-2" style="font-size: 0.7rem; letter-spacing: 0.5px;">
            <i class="bi bi-folder-fill me-1"></i> Catálogos Base
        </li>

        <!-- Módulo Localidades -->
        <li class="nav-item">
            <a href="{{ route('localidades.index') }}" class="nav-link text-white d-flex align-items-center gap-2 {{ request()->routeIs('localidades.*') ? 'active bg-success' : 'hover-bg-dark-subtle' }}">
                <i class="bi bi-geo-alt-fill text-warning"></i>
                <span>Localidades</span>
            </a>
        </li>

        <!-- Módulo Programas Sociales -->
        <li class="nav-item">
            <a href="{{ route('programas-sociales.index') }}" class="nav-link text-white d-flex align-items-center gap-2 {{ request()->routeIs('programas-sociales.*') ? 'active bg-success' : 'hover-bg-dark-subtle' }}">
                <i class="bi bi-journal-check text-warning"></i>
                <span>Programas Sociales</span>
            </a>
        </li>

        <!-- Módulo Padrón de Beneficiarios -->
        <li class="nav-item">
            <a href="{{ route('beneficiarios.index') }}" class="nav-link text-white d-flex align-items-center gap-2 {{ request()->routeIs('beneficiarios.*') ? 'active bg-success' : 'hover-bg-dark-subtle' }}">
                <i class="bi bi-people-fill text-warning"></i>
                <span>Padrón de Beneficiarios</span>
            </a>
        </li>

        <!-- ==================================================== -->
        <!-- SECCIÓN 2: OPERACIÓN Y CRUCES (Entregas y Asignación)-->
        <!-- ==================================================== -->
        <li class="nav-header text-uppercase text-secondary font-monospace mt-3 mb-1 px-2" style="font-size: 0.7rem; letter-spacing: 0.5px;">
            <i class="bi bi-diagram-3-fill me-1"></i> Operación Conjunta
        </li>

        <!-- Módulo Asignación y Entregas de Apoyos -->
        <li class="nav-item">
            <a href="{{ route('entregas.index') }}" class="nav-link text-white d-flex align-items-center gap-2 {{ request()->routeIs('entregas.*') ? 'active bg-success' : 'hover-bg-dark-subtle' }}">
                <i class="bi bi-box-seam-fill text-info"></i>
                <span>Entrega de Apoyos</span>
            </a>
        </li>

        <!-- ==================================================== -->
        <!-- SECCIÓN 3: ADMINISTRACIÓN & USUARIOS                -->
        <!-- ==================================================== -->
        <li class="nav-header text-uppercase text-secondary font-monospace mt-3 mb-1 px-2" style="font-size: 0.7rem; letter-spacing: 0.5px;">
            <i class="bi bi-gear-fill me-1"></i> Administración
        </li>

        <!-- Botón para Abrir Modal de Registro -->
        <li class="nav-item">
            <a href="#" class="nav-link text-white d-flex align-items-center gap-2 hover-bg-dark-subtle" data-bs-toggle="modal" data-bs-target="#modalRegistroUsuario">
                <i class="bi bi-person-plus-fill text-success"></i>
                <span>Registrar Usuario</span>
            </a>
        </li>

    </ul>

    <hr class="border-secondary my-2">

    <!-- Pie de Sidebar / Info del Sistema -->
    <div class="px-2 py-1 text-secondary" style="font-size: 0.75rem;">
        <i class="bi bi-info-circle me-1"></i> SIGAM v1.0
    </div>
</aside>

<!-- ==================================================== -->
<!-- MODAL DE REGISTRO CYBER-DARK DE USUARIOS            -->
<!-- ==================================================== -->
<div class="modal fade" id="modalRegistroUsuario" tabindex="-1" aria-labelledby="modalRegistroLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content text-white border-0 shadow-lg" style="background-color: #0b0f19; border: 1px solid rgba(16, 185, 129, 0.3) !important;">
            
            <!-- Header del Modal -->
            <div class="modal-header border-secondary border-opacity-25 pb-2">
                <div>
                    <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 mb-1" style="font-size: 0.65rem;">
                        CONTROL DE ACCESO
                    </span>
                    <h5 class="modal-title fw-bold text-white mb-0" id="modalRegistroLabel">
                        <i class="bi bi-person-badge text-success me-1"></i> Alta de Nuevo Usuario
                    </h5>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <!-- Formulario AJAX -->
            <form id="formRegistroSidebar">
                @csrf
                <div class="modal-body py-3">
                    
                    <!-- Alerta para mensajes de AJAX -->
                    <div id="alertRegistro" class="alert d-none py-2 small" role="alert"></div>

                    <!-- Nombre Completo -->
                    <div class="mb-3">
                        <label class="form-label text-light small fw-semibold mb-1">Nombre Completo</label>
                        <input type="text" name="name" class="form-control bg-dark text-white border-secondary border-opacity-50 py-2" placeholder="Ej. Juan Pérez" required>
                    </div>

                    <!-- Correo Electrónico -->
                    <div class="mb-3">
                        <label class="form-label text-light small fw-semibold mb-1">Correo Electrónico</label>
                        <input type="email" name="email" class="form-control bg-dark text-white border-secondary border-opacity-50 py-2" placeholder="usuario@ocoyoacac.gob.mx" required>
                    </div>

                    <!-- Dependencia Municipal -->
                    <div class="mb-3">
                        <label class="form-label text-light small fw-semibold mb-1">Dependencia Municipal</label>
                        <select name="dependencia_id" class="form-select bg-dark text-white border-secondary border-opacity-50 py-2" style="color-scheme: dark;" required>
                            <option value="" disabled selected>-- Selecciona Dependencia --</option>
                            @php
                                $listaDependencias = $dependencias ?? \App\Models\Dependencia::all();
                            @endphp
                            @foreach($listaDependencias as $dependencia)
                                <option value="{{ $dependencia->id }}" class="bg-dark text-white">
                                    {{ $dependencia->nombre }} ({{ $dependencia->siglas }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Rol Operativo -->
                    <div class="mb-3">
                        <label class="form-label text-light small fw-semibold mb-1">Rol Operativo</label>
                        <select name="role" class="form-select bg-dark text-white border-secondary border-opacity-50 py-2" style="color-scheme: dark;" required>
                            <option value="capturista">Capturista Operativo</option>
                            <option value="supervisor">Supervisor de Área</option>
                            <option value="admin">Administrador del Sistema</option>
                        </select>
                    </div>

                    <!-- Contraseñas -->
                    <div class="row g-2">
                        <div class="col-6 mb-2">
                            <label class="form-label text-light small fw-semibold mb-1">Contraseña</label>
                            <input type="password" name="password" class="form-control bg-dark text-white border-secondary border-opacity-50 py-2" placeholder="••••••••" required>
                        </div>
                        <div class="col-6 mb-2">
                            <label class="form-label text-light small fw-semibold mb-1">Confirmar</label>
                            <input type="password" name="password_confirmation" class="form-control bg-dark text-white border-secondary border-opacity-50 py-2" placeholder="••••••••" required>
                        </div>
                    </div>

                </div>

                <!-- Footer del Modal -->
                <div class="modal-footer border-secondary border-opacity-25 pt-2">
                    <button type="button" class="btn btn-outline-secondary btn-sm px-3" data-bs-dismiss="modal">
                        Cancelar
                    </button>
                    <button type="submit" id="btnGuardarUserSidebar" class="btn btn-success btn-sm fw-bold px-3">
                        <i class="bi bi-check-lg me-1"></i> Guardar Usuario
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>