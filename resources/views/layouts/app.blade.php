<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'SIGAM') - H. Ayuntamiento de Ocoyoacac</title>

    <!-- Bootstrap 5.3 CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <!-- Bootstrap Icons CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- Estilos Personalizados del Sistema -->
    <style>
        body {
            font-family: system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            background-color: #f8f9fa;
        }
        #main-content {
            margin-left: 260px;
            transition: all 0.3s ease;
            min-height: calc(100vh - 56px);
        }
        .sidebar-collapsed #sidebar {
            margin-left: -260px;
        }
        .sidebar-collapsed #main-navbar,
        .sidebar-collapsed #main-content {
            margin-left: 0 !important;
        }
        @media (max-width: 991.98px) {
            #sidebar {
                margin-left: -260px;
            }
            #main-navbar, #main-content {
                margin-left: 0 !important;
            }
            .sidebar-open #sidebar {
                margin-left: 0;
            }
        }
    </style>
    @stack('styles')
</head>
<body>

    <!-- Sidebar Menú -->
    @include('layouts.partials.sidebar')

    <!-- Navbar Barra Superior -->
    @include('layouts.partials.navbar')

    <!-- Contenido Principal -->
    <main id="main-content" class="p-4">
        <!-- Alertas de Notificación Globales -->
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show shadow-sm border-0 border-start border-success border-4 mb-4" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show shadow-sm border-0 border-start border-danger border-4 mb-4" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Inyección del contenido de la vista -->
        @yield('content')
    </main>

    <!-- Bootstrap 5.3 JS Bundle CDN (con Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <!-- Script Colapsable del Sidebar -->
    <script>
        const sidebarToggleBtn = document.getElementById('sidebarToggle');
        if (sidebarToggleBtn) {
            sidebarToggleBtn.addEventListener('click', function () {
                document.body.classList.toggle('sidebar-collapsed');
                document.body.classList.toggle('sidebar-open');
            });
        }
    </script>

    <!-- ==================================================== -->
    <!-- SCRIPT AJAX PARA REGISTRO DE USUARIOS DESDE SIDEBAR  -->
    <!-- ==================================================== -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
    const formRegistro = document.getElementById('formRegistroSidebar');

    if (formRegistro) {
        formRegistro.addEventListener('submit', async function (e) {
            e.preventDefault();

            const btnSubmit = document.getElementById('btnGuardarUserSidebar');
            const alertBox  = document.getElementById('alertRegistro');
            
            // Botón en modo "Guardando..."
            btnSubmit.disabled = true;
            btnSubmit.innerHTML = '<span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span> Guardando...';
            
            alertBox.classList.add('d-none');
            alertBox.className = 'alert py-2 small';

            // Capturamos el token CSRF explícitamente
            const tokenMeta = document.querySelector('meta[name="csrf-token"]');
            const token = tokenMeta ? tokenMeta.getAttribute('content') : '';

            try {
                const response = await fetch("{{ route('admin.users.storeModal') }}", {
                    method: "POST",
                    headers: {
                        "X-CSRF-TOKEN": token,
                        "X-Requested-With": "XMLHttpRequest",
                        "Accept": "application/json"
                    },
                    body: new FormData(formRegistro)
                });

                const data = await response.json();

                if (response.ok) {
                    // Éxito al registrar
                    alertBox.classList.add('alert-success');
                    alertBox.textContent = data.message;
                    alertBox.classList.remove('d-none');

                    formRegistro.reset();

                    // Ocultar modal automáticamente después de 1.8 seg
                    setTimeout(() => {
                        alertBox.classList.add('d-none');
                        const modalElement = document.getElementById('modalRegistroUsuario');
                        const modalInstance = bootstrap.Modal.getInstance(modalElement);
                        if (modalInstance) {
                            modalInstance.hide();
                        }
                        // Opcional: Recargar página para actualizar tablas si estás en lista de usuarios
                        // window.location.reload(); 
                    }, 1800);

                } else {
                    // Mostrar errores de validación
                    let errorMsg = data.message || 'Ocurrió un error al procesar el registro.';
                    if (data.errors) {
                        const firstKey = Object.keys(data.errors)[0];
                        errorMsg = data.errors[firstKey][0];
                    }
                    alertBox.classList.add('alert-danger');
                    alertBox.textContent = errorMsg;
                    alertBox.classList.remove('d-none');
                }
            } catch (error) {
                alertBox.classList.add('alert-danger');
                alertBox.textContent = 'Error de conexión o token caducado.';
                alertBox.classList.remove('d-none');
            } finally {
                btnSubmit.disabled = false;
                btnSubmit.innerHTML = '<i class="bi bi-check-lg me-1"></i> Guardar Usuario';
            }
        });
    }
});
    </script>

    @stack('scripts')
</body>
</html>