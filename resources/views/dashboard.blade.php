@extends('layouts.app')

@section('title', 'Panel Principal')

@push('styles')
<!-- Leaflet CSS para el Mapa -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<style>
    /* Estilos Neón Dark Executive */
    .bg-dark-executive {
        background-color: #0f172a !important; /* Slate 900 */
    }
    .card-dark {
        background: #1e293b; /* Slate 800 */
        border: 1px solid rgba(255, 255, 255, 0.08);
        color: #f8fafc;
    }
    .card-kpi {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
    }
    .card-kpi:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 24px -10px rgba(16, 185, 129, 0.3);
    }
    .kpi-glow-emerald {
        border-left: 4px solid #10b981 !important;
    }
    .kpi-glow-cyan {
        border-left: 4px solid #06b6d4 !important;
    }
    .kpi-glow-amber {
        border-left: 4px solid #f59e0b !important;
    }
    .kpi-glow-purple {
        border-left: 4px solid #a855f7 !important;
    }

    /* Estilo del Mapa Dark */
    #mapa-ocoyoacac {
        height: 480px;
        width: 100%;
        border-radius: 0 0 0.75rem 0.75rem;
        z-index: 1;
        background: #0f172a;
    }

    /* Marcador Pulso Tipo Radar */
    .radar-pulse-icon {
        position: relative;
    }
    .radar-pulse {
        width: 16px;
        height: 16px;
        background-color: #10b981;
        border-radius: 50%;
        box-shadow: 0 0 10px #10b981, 0 0 20px #10b981;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
    }
    .radar-pulse::after {
        content: '';
        width: 32px;
        height: 32px;
        border: 2px solid #10b981;
        border-radius: 50%;
        position: absolute;
        top: -10px;
        left: -10px;
        animation: pulse-ring 1.8s infinite cubic-bezier(0.215, 0.61, 0.355, 1);
        opacity: 0;
    }

    @keyframes pulse-ring {
        0% { transform: scale(0.3); opacity: 0.8; }
        80%, 100% { transform: scale(1.5); opacity: 0; }
    }

    /* Popups Estilizados del Mapa */
    .leaflet-popup-content-wrapper {
        background: #1e293b !important;
        color: #f8fafc !important;
        border: 1px solid #10b981;
        border-radius: 8px !important;
    }
    .leaflet-popup-tip {
        background: #1e293b !important;
    }
</style>
@endpush

@section('content')
<div class="container-fluid px-0">

    <!-- CABECERA PRINCIPAL -->
    <div class="card card-dark bg-dark-executive p-4 mb-4 border-0 rounded-4 shadow-lg">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
            <div>
                <div class="d-flex align-items-center gap-2 mb-1">
                    <span class="badge bg-success bg-opacity-25 text-success border border-success border-opacity-50 px-2 py-1 small">
                        <i class="bi bi-shield-check me-1"></i> MONITOREO ACTIVO
                    </span>
                    <span class="text-muted small font-monospace">H. AYUNTAMIENTO DE OCOYOACAC</span>
                </div>
                <h2 class="fw-extrabold mb-1 text-white text-uppercase tracking-wide">
                    Panel de Control Operativo
                </h2>
                <p class="text-secondary small mb-0">Sistema Integral de Gestión de Apoyos Municipales (SIGAM)</p>
            </div>
            <div class="d-flex align-items-center gap-2">
                <button class="btn btn-outline-light btn-sm rounded-3 px-3 d-flex align-items-center gap-2" onclick="window.location.reload();">
                    <i class="bi bi-arrow-repeat"></i> Sincronizar
                </button>
                <button class="btn btn-success btn-sm rounded-3 px-3 fw-bold d-flex align-items-center gap-2 shadow" data-bs-toggle="modal" data-bs-target="#modalRegistroUsuario">
                    <i class="bi bi-plus-lg"></i> Alta de Usuario
                </button>
            </div>
        </div>
    </div>

    <!-- TARJETAS METRICAS NEÓN (KPIs) -->
    <div class="row g-3 mb-4">
        <!-- Beneficiarios Padrón -->
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card card-dark card-kpi kpi-glow-emerald rounded-4 p-3 shadow-sm">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-uppercase text-secondary fw-bold font-monospace" style="font-size:0.7rem;">Padrón Registrado</span>
                        <h2 class="fw-bold text-white mb-0 mt-1">{{ number_format($totalBeneficiarios ?? 0) }}</h2>
                        <small class="text-success fw-semibold"><i class="bi bi-graph-up-arrow me-1"></i>Beneficiarios Activos</small>
                    </div>
                    <div class="p-3 bg-success bg-opacity-10 rounded-circle text-success fs-3">
                        <i class="bi bi-people-fill"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Apoyos Entregados -->
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card card-dark card-kpi kpi-glow-cyan rounded-4 p-3 shadow-sm">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-uppercase text-secondary fw-bold font-monospace" style="font-size:0.7rem;">Total Entregas</span>
                        <h2 class="fw-bold text-white mb-0 mt-1">{{ number_format($totalEntregas ?? 0) }}</h2>
                        <small class="text-info fw-semibold"><i class="bi bi-check-circle-fill me-1"></i>Operaciones Concluidas</small>
                    </div>
                    <div class="p-3 bg-info bg-opacity-10 rounded-circle text-info fs-3">
                        <i class="bi bi-box-seam-fill"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Programas Sociales -->
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card card-dark card-kpi kpi-glow-amber rounded-4 p-3 shadow-sm">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-uppercase text-secondary fw-bold font-monospace" style="font-size:0.7rem;">Programas Sociales</span>
                        <h2 class="fw-bold text-white mb-0 mt-1">{{ number_format($totalProgramas ?? 0) }}</h2>
                        <small class="text-warning fw-semibold"><i class="bi bi-layers-fill me-1"></i>En Operación</small>
                    </div>
                    <div class="p-3 bg-warning bg-opacity-10 rounded-circle text-warning fs-3">
                        <i class="bi bi-journal-bookmark-fill"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Cobertura Localidades -->
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card card-dark card-kpi kpi-glow-purple rounded-4 p-3 shadow-sm">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-uppercase text-secondary fw-bold font-monospace" style="font-size:0.7rem;">Localidades Impactadas</span>
                        <h2 class="fw-bold text-white mb-0 mt-1">{{ number_format($totalLocalidades ?? 0) }}</h2>
                        <small class="text-purple fw-semibold" style="color:#a855f7;"><i class="bi bi-geo-alt-fill me-1"></i>Cobertura Territorial</small>
                    </div>
                    <div class="p-3 bg-opacity-10 rounded-circle fs-3" style="background: rgba(168, 85, 247, 0.1); color: #a855f7;">
                        <i class="bi bi-pin-map-fill"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- SECCIÓN DE MAPA Y BITÁCORA RECIENTE -->
    <div class="row g-4">
        <!-- MAPA DE COBERTURA -->
        <div class="col-12 col-lg-8">
            <div class="card card-dark rounded-4 shadow-lg border-0 h-100">
                <div class="card-header bg-transparent border-bottom border-secondary border-opacity-25 py-3 d-flex justify-content-between align-items-center">
                    <h6 class="mb-0 fw-bold text-white d-flex align-items-center gap-2">
                        <i class="bi bi-map-fill text-success"></i> Mapa de Cobertura de Apoyos
                    </h6>
                    <span class="badge bg-dark border border-success text-success font-monospace">OCOYOACAC</span>
                </div>
                <div class="card-body p-0 position-relative">
                    <div id="mapa-ocoyoacac"></div>
                </div>
            </div>
        </div>

        <!-- RESUMEN LATERAL & BITÁCORA -->
        <div class="col-12 col-lg-4">
            <div class="card card-dark rounded-4 shadow-lg border-0 h-100 d-flex flex-column">
                <div class="card-header bg-transparent border-bottom border-secondary border-opacity-25 py-3">
                    <h6 class="mb-0 fw-bold text-white d-flex align-items-center gap-2">
                        <i class="bi bi-clock-history text-info"></i> Últimas Entregas Registradas
                    </h6>
                </div>
                <div class="card-body p-0 flex-grow-1 overflow-auto" style="max-height: 420px;">
                    <div class="list-group list-group-flush bg-transparent">
                        @forelse($ultimasEntregas ?? [] as $entrega)
                            <div class="list-group-item bg-transparent text-white border-bottom border-secondary border-opacity-25 p-3">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <strong class="text-white small fw-bold">{{ $entrega->beneficiario->nombre ?? 'Beneficiario' }}</strong>
                                    <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 font-monospace" style="font-size: 0.65rem;">
                                        {{ optional($entrega->created_at)->diffForHumans() ?? 'Reciente' }}
                                    </span>
                                </div>
                                <div class="text-secondary small mb-1">
                                    <i class="bi bi-box-seam text-warning me-1"></i>
                                    {{ $entrega->programaSocial->nombre ?? 'Programa Social' }}
                                </div>
                                <div class="text-info small font-monospace d-flex align-items-center gap-1" style="font-size:0.75rem;">
                                    <i class="bi bi-geo-alt text-danger"></i>
                                    {{ $entrega->beneficiario->localidad->nombre ?? 'Localidad' }}
                                </div>
                            </div>
                        @empty
                            <div class="p-4 text-center text-secondary">
                                <i class="bi bi-inbox fs-1 d-block mb-2 opacity-50 text-success"></i>
                                <span>No se han registrado entregas recientemente.</span>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<!-- Leaflet JS -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    
    // 1. Inicializar mapa centrado en Ocoyoacac
    const map = L.map('mapa-ocoyoacac', {
        zoomControl: true,
        attributionControl: false
    }).setView([19.2731, -99.4612], 13);

    // 2. Capa Estilo Oscuro CartoDB
    L.tileLayer('https://{s}.basemaps.cartocdn.com/dark_all/{z}/{x}/{y}{r}.png', {
        maxZoom: 19,
        subdomains: 'abcd'
    }).addTo(map);

    // 3. Diccionario de respaldo ampliado (Fallback por si no vienen coords desde la BD)
    const coordenadasFallback = {
        "centro": [19.2731, -99.4612],
        "cabecera municipal": [19.2731, -99.4612],
        "cabecera": [19.2731, -99.4612],
        "san pedro tultepec": [19.2778, -99.4917],
        "tultepec": [19.2778, -99.4917],
        "coapanoaya": [19.2615, -99.4589],
        "el pedregal": [19.2812, -99.4520],
        "pedregal": [19.2812, -99.4520],
        "la marquesa": [19.3142, -99.3801],
        "marquesa": [19.3142, -99.3801],
        "juarez": [19.2690, -99.4680],
        "juárez": [19.2690, -99.4680],
        "lomas de los angeles": [19.2890, -99.4720],
        "lomas de los ángeles": [19.2890, -99.4720],
        "tepexoyuca": [19.2550, -99.4480],
        "san jeronimo acazulco": [19.2950, -99.4120],
        "san jerónimo acazulco": [19.2950, -99.4120],
        "acazulco": [19.2950, -99.4120],
        "cholula": [19.2710, -99.4550]
    };

    // 4. Datos transmitidos desde Laravel
    const datosEntregas = @json($puntosMapa ?? []);

    console.log("Datos del Backend:", datosEntregas);

    // Icono personalizado con pulso radar
    const radarIcon = L.divIcon({
        className: 'radar-pulse-icon',
        html: '<div class="radar-pulse"></div>',
        iconSize: [20, 20],
        iconAnchor: [10, 10]
    });

    // 5. Renderizado Inteligente
    const renderizarMarcador = (nombre, lat, lng, total) => {
        let coords = null;

        // Opción A: Viene de la BD con coordenadas válidas
        if (lat && lng && !isNaN(parseFloat(lat)) && !isNaN(parseFloat(lng))) {
            coords = [parseFloat(lat), parseFloat(lng)];
        } 
        // Opción B: Si lat/lng vienen nulos o vacíos, busca en el diccionario
        else if (nombre) {
            const clave = nombre.toString().toLowerCase().trim();
            if (coordenadasFallback[clave]) {
                coords = coordenadasFallback[clave];
            }
        }

        if (coords) {
            const marker = L.marker(coords, { icon: radarIcon }).addTo(map);

            const popupContent = `
                <div style="font-family: system-ui; text-align: center; padding: 4px;">
                    <span style="font-size:0.65rem; font-weight:bold; color:#10b981; letter-spacing:1px; text-transform:uppercase;">Localidad</span>
                    <h6 style="margin:2px 0 8px 0; font-weight:bold; color:#ffffff;">${nombre}</h6>
                    <div style="background:#0f172a; padding:8px; border-radius:6px; border:1px solid #334155;">
                        <small style="color:#94a3b8; font-size:0.75rem;">Apoyos Entregados:</small><br>
                        <strong style="font-size:1.2rem; color:#10b981;">${total}</strong>
                    </div>
                </div>
            `;

            marker.bindPopup(popupContent);
        } else {
            console.warn(`Sin ubicación asignada para: "${nombre}"`);
        }
    };

    // 6. Procesar la estructura JSON de manera robusta
    if (Array.isArray(datosEntregas)) {
        datosEntregas.forEach(item => {
            const nombre = item.localidad || item.nombre || 'Desconocido';
            const total = item.total ?? item.total_entregas ?? 1;
            renderizarMarcador(nombre, item.latitud, item.longitud, total);
        });
    } else if (typeof datosEntregas === 'object' && datosEntregas !== null) {
        Object.keys(datosEntregas).forEach(localidad => {
            const info = datosEntregas[localidad];
            if (typeof info === 'object' && info !== null) {
                const lat = info.latitud ?? info.lat ?? null;
                const lng = info.longitud ?? info.lng ?? null;
                const total = info.total ?? info.cantidad ?? 1;
                renderizarMarcador(localidad, lat, lng, total);
            } else {
                // Si la estructura era simple Key-Value -> "Centro": 5
                renderizarMarcador(localidad, null, null, info);
            }
        });
    }

});
</script>
@endpush