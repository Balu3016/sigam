<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>403 - Acceso Restringido | SIGAM Ocoyoacac</title>
    <!-- Bootstrap 5 CSS & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
    <style>
        body {
            background-color: #0b0f19;
            color: #e2e8f0;
            font-family: system-ui, -apple-system, "Segoe UI", Roboto, sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            position: relative;
        }

        /* Fondo dinámico con resplandor Cyber-Dark */
        .glow-bg {
            position: absolute;
            width: 500px;
            height: 500px;
            background: radial-gradient(circle, rgba(239, 68, 68, 0.15) 0%, rgba(11, 15, 25, 0) 70%);
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 0;
            pointer-events: none;
        }

        .card-cyber {
            background-color: rgba(15, 23, 42, 0.85);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(239, 68, 68, 0.3) !important;
            box-shadow: 0 0 35px rgba(239, 68, 68, 0.15);
            border-radius: 1rem;
            z-index: 1;
            max-width: 520px;
            width: 100%;
        }

        .badge-security {
            background-color: rgba(239, 68, 68, 0.1);
            color: #ef4444;
            border: 1px solid rgba(239, 68, 68, 0.3);
            font-size: 0.7rem;
            letter-spacing: 1px;
        }

        .icon-box {
            width: 80px;
            height: 80px;
            background: rgba(239, 68, 68, 0.1);
            border: 1px solid rgba(239, 68, 68, 0.25);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem auto;
            box-shadow: 0 0 20px rgba(239, 68, 68, 0.2);
        }

        .btn-cyber {
            background-color: #10b981;
            color: #ffffff;
            border: none;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-cyber:hover {
            background-color: #059669;
            color: #ffffff;
            box-shadow: 0 0 15px rgba(16, 185, 129, 0.4);
            transform: translateY(-1px);
        }

        .btn-outline-cyber {
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: #94a3b8;
            transition: all 0.3s ease;
        }

        .btn-outline-cyber:hover {
            background-color: rgba(255, 255, 255, 0.05);
            color: #ffffff;
            border-color: rgba(255, 255, 255, 0.4);
        }
    </style>
</head>
<body>

    <div class="glow-bg"></div>

    <div class="container p-3">
        <div class="card card-cyber p-4 p-md-5 text-center mx-auto">
            
            <!-- Marca Institucional -->
            <div class="d-flex align-items-center justify-content-center gap-2 mb-4">
                <div class="bg-success rounded-2 p-1 d-flex align-items-center justify-content-center" style="width: 28px; height: 28px;">
                    <i class="bi bi-shield-check text-warning fs-6"></i>
                </div>
                <span class="fw-bold tracking-wide text-uppercase fs-6">OCOYOACAC</span>
                <span class="text-secondary font-monospace fs-7">| SIGAM</span>
            </div>

            <!-- Icono Central con Pulso -->
            <div class="icon-box">
                <i class="bi bi-shield-lock-fill text-danger fs-1"></i>
            </div>

            <!-- Badge & Título -->
            <span class="badge badge-security text-uppercase font-monospace px-3 py-1 rounded-pill mb-2 align-self-center">
                ERROR 403 • ACCESO RESTRINGIDO
            </span>

            <h3 class="fw-bold text-white mb-2">Permisos Insuficientes</h3>
            
            <p class="text-secondary small mb-4">
                {{ $exception->getMessage() ?: 'Tu nivel de usuario no cuenta con las atribuciones necesarias para acceder a este módulo del sistema.' }}
            </p>

            <!-- Metadata de Auditoría Breve -->
            <div class="bg-dark bg-opacity-50 border border-secondary border-opacity-25 rounded p-2 mb-4 font-monospace text-start" style="font-size: 0.75rem;">
                <div class="text-secondary"><i class="bi bi-person-fill text-danger me-1"></i> Usuario: <span class="text-light">{{ auth()->user()->name ?? 'Invitado' }}</span></div>
                <div class="text-secondary"><i class="bi bi-person-badge-fill text-warning me-1"></i> Rol Actual: <span class="text-light text-uppercase">{{ auth()->user()->role ?? 'Sin Rol' }}</span></div>
            </div>

            <!-- Botones de Acción -->
            <div class="d-flex flex-column flex-sm-row gap-2 justify-content-center">
                <a href="{{ url()->previous() }}" class="btn btn-outline-cyber btn-sm px-4 py-2 rounded-2">
                    <i class="bi bi-arrow-left me-1"></i> Regresar
                </a>
                <a href="{{ route('dashboard') }}" class="btn btn-cyber btn-sm px-4 py-2 rounded-2">
                    <i class="bi bi-speedometer2 me-1"></i> Panel Principal
                </a>
            </div>

            <!-- Footer -->
            <div class="mt-4 pt-3 border-top border-secondary border-opacity-25 text-secondary" style="font-size: 0.65rem;">
                Gobierno Municipal de Ocoyoacac • Sistema de Gestión de Apoyos Municipales
            </div>

        </div>
    </div>

</body>
</html>