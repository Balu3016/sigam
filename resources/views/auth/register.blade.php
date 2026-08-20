<x-guest-layout>

    <!-- Estilos de ajuste para evitar el desbordamiento dentro de x-guest-layout -->
    <style>
        /* Desactivar desbordamientos y ajustar cajas */
        .form-control-cyber, .form-select-cyber {
            background-color: #0b0f19 !important;
            border: 1px solid rgba(16, 185, 129, 0.3) !important;
            color: #ffffff !important;
            font-size: 0.9rem;
        }

        .form-control-cyber:focus, .form-select-cyber:focus {
            border-color: #10b981 !important;
            box-shadow: 0 0 8px rgba(16, 185, 129, 0.4) !important;
        }

        /* Asegurar que las cajas no se salgan del guest-layout */
        .input-group, .form-select, .form-control {
            max-width: 100% !important;
            box-sizing: border-box !important;
        }

        .cyber-badge {
            background: rgba(16, 185, 129, 0.1);
            border: 1px solid rgba(16, 185, 129, 0.3);
            color: #34d399;
            font-size: 0.7rem;
            padding: 0.2rem 0.6rem;
            border-radius: 50rem;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .btn-neon-emerald {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            border: none;
            color: #ffffff;
            font-weight: bold;
            box-shadow: 0 0 12px rgba(16, 185, 129, 0.4);
        }
    </style>

    <div class="w-100 px-1">
        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- Encabezado compacto -->
            <div class="text-center mb-3">
                <span class="cyber-badge mb-1 d-inline-block">
                    Alta de Personal
                </span>
                <h4 class="text-white fw-bold mb-0">
                    Registro de Usuario
                </h4>
                <p class="text-muted small mb-0">
                    Plataforma Institucional SIGAM
                </p>
            </div>

            <!-- Nombre Completo -->
            <div class="mb-2">
                <label for="name" class="form-label text-light small mb-1 fw-semibold">
                    Nombre Completo
                </label>
                <input
                    id="name"
                    type="text"
                    name="name"
                    value="{{ old('name') }}"
                    class="form-control form-control-cyber py-2 @error('name') is-invalid @enderror"
                    placeholder="Ej. Juan Pérez"
                    required
                    autofocus
                >
                @error('name')
                    <div class="text-danger mt-1 small" style="font-size: 0.75rem;">{{ $message }}</div>
                @enderror
            </div>

            <!-- Correo Electrónico -->
            <div class="mb-2">
                <label for="email" class="form-label text-light small mb-1 fw-semibold">
                    Correo Electrónico
                </label>
                <input
                    id="email"
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    class="form-control form-control-cyber py-2 @error('email') is-invalid @enderror"
                    placeholder="usuario@ocoyoacac.gob.mx"
                    required
                >
                @error('email')
                    <div class="text-danger mt-1 small" style="font-size: 0.75rem;">{{ $message }}</div>
                @enderror
            </div>

            <!-- Dependencia Municipal -->
            <div class="mb-2">
                <label for="dependencia_id" class="form-label text-light small mb-1 fw-semibold">
                    Dependencia Municipal
                </label>
                <select
                    id="dependencia_id"
                    name="dependencia_id"
                    class="form-select form-select-cyber py-2 @error('dependencia_id') is-invalid @enderror"
                    style="color-scheme: dark; width: 100%;"
                    required
                >
                    <option value="" disabled {{ old('dependencia_id') ? '' : 'selected' }} class="bg-dark text-white">
                        -- Selecciona Dependencia --
                    </option>
                    @foreach($dependencias as $dependencia)
                        <option value="{{ $dependencia->id }}" {{ old('dependencia_id') == $dependencia->id ? 'selected' : '' }} class="bg-dark text-white">
                            {{ $dependencia->nombre }} ({{ $dependencia->siglas }})
                        </option>
                    @endforeach
                </select>
                @error('dependencia_id')
                    <div class="text-danger mt-1 small" style="font-size: 0.75rem;">{{ $message }}</div>
                @enderror
            </div>

            <!-- Rol Operativo -->
            <div class="mb-2">
                <label for="role" class="form-label text-light small mb-1 fw-semibold">
                    Rol Operativo Asignado
                </label>
                <select
                    id="role"
                    name="role"
                    class="form-select form-select-cyber py-2 @error('role') is-invalid @enderror"
                    style="color-scheme: dark; width: 100%;"
                    required
                >
                    <option value="capturista" {{ old('role', 'capturista') == 'capturista' ? 'selected' : '' }} class="bg-dark text-white">
                        Capturista Operativo
                    </option>
                    <option value="supervisor" {{ old('role') == 'supervisor' ? 'selected' : '' }} class="bg-dark text-white">
                        Supervisor de Área
                    </option>
                    <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }} class="bg-dark text-white">
                        Administrador del Sistema
                    </option>
                </select>
                @error('role')
                    <div class="text-danger mt-1 small" style="font-size: 0.75rem;">{{ $message }}</div>
                @enderror
            </div>

            <!-- Contraseña -->
            <div class="mb-2">
                <label for="password" class="form-label text-light small mb-1 fw-semibold">
                    Contraseña
                </label>
                <input
                    id="password"
                    type="password"
                    name="password"
                    class="form-control form-control-cyber py-2 @error('password') is-invalid @enderror"
                    placeholder="••••••••"
                    required
                >
                @error('password')
                    <div class="text-danger mt-1 small" style="font-size: 0.75rem;">{{ $message }}</div>
                @enderror
            </div>

            <!-- Confirmar Contraseña -->
            <div class="mb-3">
                <label for="password_confirmation" class="form-label text-light small mb-1 fw-semibold">
                    Confirmar Contraseña
                </label>
                <input
                    id="password_confirmation"
                    type="password"
                    name="password_confirmation"
                    class="form-control form-control-cyber py-2"
                    placeholder="••••••••"
                    required
                >
            </div>

            <!-- Botón de Registro -->
            <div class="d-grid my-3">
                <button type="submit" class="btn btn-neon-emerald py-2">
                    Registrar Cuenta de Usuario
                </button>
            </div>

            <!-- Enlace Login -->
            <div class="text-center pt-2">
                <a href="{{ route('login') }}" class="text-decoration-none small fw-semibold" style="color: #34d399;">
                    ¿Ya tienes cuenta? Inicia sesión aquí
                </a>
            </div>

        </form>
    </div>

</x-guest-layout>