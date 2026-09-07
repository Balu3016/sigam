@extends('layouts.app')

@section('title', 'Padrón de Usuarios del Sistema')

@section('content')
<div class="container-fluid px-0">

    <!-- Mensajes de Alerta / Éxito -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Encabezado de la Sección -->
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h4 class="fw-bold text-dark mb-1">
                <i class="bi bi-people-fill text-success me-2"></i>Usuarios del Sistema
            </h4>
            <p class="text-muted small mb-0">
                Consulta los servidores públicos activos y las dependencias a las que están asignados.
            </p>
        </div>
        <div>
            <!-- Botón para abrir el Modal de registro del Sidebar -->
            <button type="button" class="btn btn-success d-inline-flex align-items-center gap-2 shadow-sm fw-bold" data-bs-toggle="modal" data-bs-target="#modalRegistroUsuario">
                <i class="bi bi-person-plus-fill"></i>
                <span>Nuevo Usuario</span>
            </button>
        </div>
    </div>

    <!-- Tarjeta Principal con Tabla de Usuarios -->
    <div class="card border-0 shadow-sm rounded-3">
        <div class="card-body p-0">
            
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light text-uppercase font-monospace text-muted small">
                        <tr>
                            <th class="ps-4">#</th>
                            <th>Servidor Público / Usuario</th>
                            <th>Correo Electrónico</th>
                            <th>Dependencia / Área</th>
                            <th>Rol</th>
                            <th class="text-end pe-4">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($usuarios as $user)
                            <tr>
                                <td class="ps-4 text-muted fw-bold small">{{ $loop->iteration }}</td>
                                <td>
                                    <div class="d-flex align-items-center gap-3">
                                        <!-- Avatar con la Inicial del Nombre -->
                                        <div class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center fw-bold shadow-sm" style="width: 40px; height: 40px; font-size: 0.95rem;">
                                            {{ strtoupper(substr($user->name ?? 'U', 0, 1)) }}
                                        </div>
                                        <div>
                                            <div class="fw-bold text-dark">{{ $user->name }}</div>
                                            <div class="text-muted small font-monospace">ID: #{{ $user->id }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-muted font-monospace small">
                                    <i class="bi bi-envelope me-1 text-secondary"></i>{{ $user->email }}
                                </td>
                                <td>
                                    @if($user->dependencia)
                                        <span class="badge bg-light text-dark border px-2 py-1 fs-6 fw-normal">
                                            <i class="bi bi-building me-1 text-success"></i>
                                            {{ $user->dependencia->nombre ?? $user->dependencia->nombre_dependencia }}
                                        </span>
                                    @else
                                        <span class="badge bg-light text-secondary border px-2 py-1 fs-6 fw-normal">
                                            <i class="bi bi-dash-circle me-1"></i>Sin Asignación
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill text-capitalize px-3">
                                        {{ $user->role ?? 'Capturista' }}
                                    </span>
                                </td>
                                <td class="text-end pe-4">
                                    <div class="d-inline-flex gap-1">
                                        <!-- Botón Ver Detalle (Show) -->
                                        <button type="button" 
                                                class="btn btn-sm btn-outline-info btn-show-user" 
                                                data-bs-toggle="modal" 
                                                data-bs-target="#modalVerUsuario"
                                                data-id="{{ $user->id }}"
                                                data-name="{{ $user->name }}"
                                                data-email="{{ $user->email }}"
                                                data-dependencia="{{ $user->dependencia->nombre ?? $user->dependencia->nombre_dependencia ?? 'Sin Asignación' }}"
                                                data-role="{{ $user->role ?? 'Capturista' }}"
                                                data-created="{{ $user->created_at ? $user->created_at->format('d/m/Y H:i A') : 'N/A' }}"
                                                title="Ver Ficha del Usuario">
                                            <i class="bi bi-eye-fill"></i>
                                        </button>

                                        <!-- Botón Editar con Modal y Data Attributes -->
                                        <button type="button" 
                                                class="btn btn-sm btn-outline-warning btn-edit-user" 
                                                data-bs-toggle="modal" 
                                                data-bs-target="#modalEditarUsuario"
                                                data-id="{{ $user->id }}"
                                                data-name="{{ $user->name }}"
                                                data-email="{{ $user->email }}"
                                                data-dependencia="{{ $user->dependencia_id }}"
                                                data-role="{{ $user->role }}"
                                                title="Editar usuario">
                                            <i class="bi bi-pencil-square"></i>
                                        </button>

                                        <!-- Botón Eliminar -->
                                        <form action="{{ route('usuarios.destroy', $user->id) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Estás seguro de que deseas eliminar este usuario?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" title="Eliminar usuario">
                                                <i class="bi bi-trash-fill"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-5 text-muted">
                                    <i class="bi bi-people display-6 d-block mb-2 text-secondary"></i>
                                    No hay usuarios registrados en el sistema.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>

</div>

<!-- Modal para Ver Detalle del Usuario (Show) -->
<div class="modal fade" id="modalVerUsuario" tabindex="-1" aria-labelledby="modalVerUsuarioLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title fw-bold" id="modalVerUsuarioLabel">
                    <i class="bi bi-person-badge me-2"></i>Ficha de Servidor Público
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <div class="text-center mb-4">
                    <div id="show_avatar" class="bg-success text-white rounded-circle d-inline-flex align-items-center justify-content-center fw-bold shadow-sm mb-2" style="width: 70px; height: 70px; font-size: 1.8rem;">
                        U
                    </div>
                    <h5 class="fw-bold mb-0 text-dark" id="show_name">-</h5>
                    <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill text-capitalize px-3 mt-1" id="show_role">
                        -
                    </span>
                </div>

                <ul class="list-group list-group-flush border-top border-bottom mb-2">
                    <li class="list-group-item d-flex justify-content-between align-items-center px-0 py-2">
                        <span class="text-muted small"><i class="bi bi-hash me-1"></i>ID de Registro:</span>
                        <span class="fw-bold font-monospace text-dark" id="show_id">#0</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center px-0 py-2">
                        <span class="text-muted small"><i class="bi bi-envelope me-1"></i>Correo Electrónico:</span>
                        <span class="fw-bold text-dark" id="show_email">-</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center px-0 py-2">
                        <span class="text-muted small"><i class="bi bi-building me-1"></i>Dependencia / Área:</span>
                        <span class="fw-bold text-success" id="show_dependencia">-</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center px-0 py-2">
                        <span class="text-muted small"><i class="bi bi-calendar-check me-1"></i>Fecha de Registro:</span>
                        <span class="text-dark small" id="show_created">-</span>
                    </li>
                </ul>
            </div>
            <div class="modal-footer bg-light px-4 py-2">
                <button type="button" class="btn btn-secondary fw-bold" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal para Editar Usuario -->
<div class="modal fade" id="modalEditarUsuario" tabindex="-1" aria-labelledby="modalEditarUsuarioLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-warning text-dark">
                <h5 class="modal-title fw-bold" id="modalEditarUsuarioLabel">
                    <i class="bi bi-pencil-square me-2"></i>Editar Usuario
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <form id="formEditarUsuario" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body p-4">
                    
                    <!-- Alerta de errores AJAX -->
                    <div id="alertErrorEdit" class="alert alert-danger d-none" role="alert"></div>

                    <!-- Nombre -->
                    <div class="mb-3">
                        <label for="edit_name" class="form-label fw-bold small text-muted">Nombre Completo</label>
                        <input type="text" class="form-control" id="edit_name" name="name" required>
                    </div>

                    <!-- Correo -->
                    <div class="mb-3">
                        <label for="edit_email" class="form-label fw-bold small text-muted">Correo Electrónico</label>
                        <input type="email" class="form-control" id="edit_email" name="email" required>
                    </div>

                    <!-- Dependencia -->
                    <div class="mb-3">
                        <label for="edit_dependencia_id" class="form-label fw-bold small text-muted">Dependencia / Área</label>
                        <select class="form-select" id="edit_dependencia_id" name="dependencia_id" required>
                            <option value="" disabled>Selecciona una dependencia...</option>
                            @foreach(\App\Models\Dependencia::all() as $dep)
                                <option value="{{ $dep->id }}">{{ $dep->nombre ?? $dep->nombre_dependencia }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Rol -->
                    <div class="mb-3">
                        <label for="edit_role" class="form-label fw-bold small text-muted">Rol en el Sistema</label>
                        <select class="form-select" id="edit_role" name="role" required>
                            <option value="admin">Administrador</option>
                            <option value="capturista">Capturista</option>
                            <option value="operador">Operador</option>
                        </select>
                    </div>

                    <hr class="my-3">

                    <!-- Nueva Contraseña (Opcional) -->
                    <div class="mb-3">
                        <label for="edit_password" class="form-label fw-bold small text-muted">
                            Nueva Contraseña <span class="text-secondary fw-normal">(Dejar en blanco para mantener la actual)</span>
                        </label>
                        <input type="password" class="form-control" id="edit_password" name="password" autocomplete="new-password">
                    </div>

                </div>
                <div class="modal-footer bg-light px-4 py-3">
                    <button type="button" class="btn btn-secondary fw-bold" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-warning fw-bold text-dark" id="btnUpdateUsuario">
                        <i class="bi bi-check-circle-fill me-1"></i> Guardar Cambios
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- JavaScript para interactividad de Modales y AJAX -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    
    // 1. Cargar Datos al Modal de Ver (Show)
    const showButtons = document.querySelectorAll('.btn-show-user');
    showButtons.forEach(button => {
        button.addEventListener('click', function () {
            const id = this.getAttribute('data-id');
            const name = this.getAttribute('data-name');
            const email = this.getAttribute('data-email');
            const dependencia = this.getAttribute('data-dependencia');
            const role = this.getAttribute('data-role');
            const created = this.getAttribute('data-created');

            document.getElementById('show_id').innerText = '#' + id;
            document.getElementById('show_name').innerText = name;
            document.getElementById('show_email').innerText = email;
            document.getElementById('show_dependencia').innerText = dependencia;
            document.getElementById('show_role').innerText = role;
            document.getElementById('show_created').innerText = created;
            document.getElementById('show_avatar').innerText = name.charAt(0).toUpperCase();
        });
    });

    // 2. Llenar inputs del modal cuando se da clic en Editar
    const editButtons = document.querySelectorAll('.btn-edit-user');
    const formEdit = document.getElementById('formEditarUsuario');
    const alertError = document.getElementById('alertErrorEdit');

    editButtons.forEach(button => {
        button.addEventListener('click', function () {
            const userId = this.getAttribute('data-id');
            const name = this.getAttribute('data-name');
            const email = this.getAttribute('data-email');
            const dependencia = this.getAttribute('data-dependencia');
            const role = this.getAttribute('data-role');

            document.getElementById('edit_name').value = name;
            document.getElementById('edit_email').value = email;
            document.getElementById('edit_dependencia_id').value = dependencia;
            document.getElementById('edit_role').value = role;
            document.getElementById('edit_password').value = '';

            // Asignar dinámicamente la URL de actualización
            formEdit.action = `/usuarios/${userId}`;
        });
    });

    // 3. Enviar actualización vía AJAX
    formEdit.addEventListener('submit', function (e) {
        e.preventDefault();
        alertError.classList.add('d-none');
        alertError.innerHTML = '';

        const formData = new FormData(formEdit);

        fetch(formEdit.action, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            },
            body: formData
        })
        .then(response => response.json().then(data => ({ status: response.status, body: data })))
        .then(res => {
            if (res.status === 200 || res.status === 202) {
                location.reload();
            } else if (res.status === 422) {
                let errorsHtml = '<ul class="mb-0 ps-3">';
                Object.values(res.body.errors).forEach(err => {
                    errorsHtml += `<li>${err[0]}</li>`;
                });
                errorsHtml += '</ul>';
                alertError.innerHTML = errorsHtml;
                alertError.classList.remove('d-none');
            } else {
                alertError.innerText = res.body.message || 'Ocurrió un error inesperado.';
                alertError.classList.remove('d-none');
            }
        })
        .catch(err => {
            console.error(err);
            alertError.innerText = 'Error de conexión al guardar cambios.';
            alertError.classList.remove('d-none');
        });
    });
});
</script>
@endsection