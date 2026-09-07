@extends('layouts.app')

@section('title', 'Editar Entrega de Apoyo Social')

@push('styles')
<!-- Leaflet CSS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<style>
    #mapa-captura {
        height: 250px;
        border-radius: 0.5rem;
        z-index: 1;
    }
</style>
@endpush

@section('content')
<div class="container-fluid px-0">

    <!-- Encabezado del Formulario -->
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h4 class="fw-bold text-dark mb-1">
                <i class="bi bi-pencil-square text-warning me-2"></i>Editar Entrega de Apoyo Social
            </h4>
            <p class="text-muted small mb-0">
                Modifica los datos de la entrega o actualiza la ubicación georreferenciada.
            </p>
        </div>
        <div>
            <a href="{{ route('entregas.index') }}" class="btn btn-outline-secondary d-inline-flex align-items-center gap-2">
                <i class="bi bi-arrow-left"></i>
                <span>Volver al Padrón</span>
            </a>
        </div>
    </div>

    <!-- Tarjeta del Formulario -->
    <div class="card border-0 shadow-sm rounded-3">
        <div class="card-body p-4">
            
            <form action="{{ route('entregas.update', $entrega->id) }}" method="POST">
                @csrf
                @method('PUT')

                <h6 class="fw-bold text-dark text-uppercase font-monospace mb-3" style="font-size: 0.8rem;">
                    <i class="bi bi-diagram-3-fill me-2 text-primary"></i>Datos de Asignación Conjunta
                </h6>

                <div class="row g-3 mb-4">
                    
                    <!-- Selección de Beneficiario -->
                    <div class="col-12 col-md-6">
                        <label for="beneficiario_id" class="form-label fw-bold small text-dark">
                            Beneficiario (Ciudadano) <span class="text-danger">*</span>
                        </label>
                        <select name="beneficiario_id" id="beneficiario_id" class="form-select @error('beneficiario_id') is-invalid @enderror" required onchange="verificarHistorial(this)">
                            <option value="" disabled>Selecciona un ciudadano activo...</option>
                            @foreach($beneficiarios as $b)
                                @php
                                    $historial = $b->entregas->map(function($e) {
                                        $fecha = $e->fecha_entrega ? \Carbon\Carbon::parse($e->fecha_entrega)->format('d/m/Y') : 'Sin fecha';
                                        return [
                                            'id' => $e->id,
                                            'programa' => $e->programaSocial->nombre ?? 'Programa General',
                                            'usuario' => $e->usuario->name ?? 'Sistema',
                                            'fecha' => $fecha
                                        ];
                                    });
                                @endphp
                                <option value="{{ $b->id }}" 
                                        {{ old('beneficiario_id', $entrega->beneficiario_id) == $b->id ? 'selected' : '' }}
                                        data-historial='@json($historial)'>
                                    {{ $b->primer_apellido }} {{ $b->segundo_apellido }} {{ $b->nombre }} — [{{ $b->curp }}]
                                </option>
                            @endforeach
                        </select>

                        <!-- Contenedor Dinámico de Alerta Anti-Duplicidad -->
                        <div id="alerta-historial" class="mt-3 d-none">
                            <div class="alert alert-warning border-warning shadow-sm mb-0">
                                <div class="d-flex align-items-center gap-2 fw-bold text-dark mb-2">
                                    <i class="bi bi-exclamation-triangle-fill text-warning fs-5"></i>
                                    <span>Atención: Este ciudadano cuenta con apoyos registrados:</span>
                                </div>
                                <ul id="lista-historial" class="mb-0 small text-dark ps-3"></ul>
                            </div>
                        </div>
                        @error('beneficiario_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @else
                            <div class="form-text">Búsqueda rápida por nombre o CURP.</div>
                        @enderror
                    </div>

                    <!-- Selección de Programa Social -->
                    <div class="col-12 col-md-6">
                        <label for="programa_social_id" class="form-label fw-bold small text-dark">
                            Programa Social <span class="text-danger">*</span>
                        </label>
                        <select name="programa_social_id" id="programa_social_id" class="form-select @error('programa_social_id') is-invalid @enderror" required>
                            <option value="" disabled>Selecciona el programa origen...</option>
                            @foreach($programas as $p)
                                <option value="{{ $p->id }}" {{ old('programa_social_id', $entrega->programa_social_id) == $p->id ? 'selected' : '' }}>
                                    {{ $p->nombre }} ({{ $p->codigo ?? $p->clave }}) — {{ ucfirst($p->tipo_apoyo ?? 'General') }}
                                </option>
                            @endforeach
                        </select>
                        @error('programa_social_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                </div>

                <hr class="my-4 text-secondary">

                <h6 class="fw-bold text-dark text-uppercase font-monospace mb-3" style="font-size: 0.8rem;">
                    <i class="bi bi-calendar-check-fill me-2 text-primary"></i>Detalles de la Entrega y Control
                </h6>

                <div class="row g-3 mb-4">
                    
                    <!-- Fecha de Entrega -->
                    <div class="col-12 col-md-4">
                        <label for="fecha_entrega" class="form-label fw-bold small text-dark">
                            Fecha de Entrega <span class="text-danger">*</span>
                        </label>
                        <input type="date" 
                               name="fecha_entrega" 
                               id="fecha_entrega" 
                               class="form-control @error('fecha_entrega') is-invalid @enderror" 
                               value="{{ old('fecha_entrega', \Carbon\Carbon::parse($entrega->fecha_entrega)->format('Y-m-d')) }}" 
                               required>
                        @error('fecha_entrega')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Cantidad Otorgada -->
                    <div class="col-12 col-md-4">
                        <label for="cantidad" class="form-label fw-bold small text-dark">
                            Cantidad Otorgada <span class="text-danger">*</span>
                        </label>
                        <input type="number" 
                               name="cantidad" 
                               id="cantidad" 
                               min="1"
                               class="form-control @error('cantidad') is-invalid @enderror" 
                               value="{{ old('cantidad', $entrega->cantidad) }}" 
                               required>
                        @error('cantidad')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Folio / Acta de Entrega -->
                    <div class="col-12 col-md-4">
                        <label for="folio_acta" class="form-label fw-bold small text-dark">
                            Folio / No. de Recibo
                        </label>
                        <input type="text" 
                               name="folio_acta" 
                               id="folio_acta" 
                               class="form-control font-monospace @error('folio_acta') is-invalid @enderror" 
                               value="{{ old('folio_acta', $entrega->folio_acta) }}" 
                               placeholder="Ej. ACTA-2026-0089">
                        @error('folio_acta')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Observaciones -->
                    <div class="col-12">
                        <label for="observaciones" class="form-label fw-bold small text-dark">
                            Observaciones o Notas Adicionales
                        </label>
                        <textarea name="observaciones" 
                                  id="observaciones" 
                                  rows="2" 
                                  class="form-control @error('observaciones') is-invalid @enderror" 
                                  placeholder="Detalles sobre las condiciones de la entrega o documentación cotejada...">{{ old('observaciones', $entrega->observaciones) }}</textarea>
                        @error('observaciones')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                </div>

                <hr class="my-4 text-secondary">

                <!-- Sección: Geolocalización del Apoyo -->
                <h6 class="fw-bold text-dark text-uppercase font-monospace mb-3" style="font-size: 0.8rem;">
                    <i class="bi bi-geo-alt-fill me-2 text-danger"></i>Geolocalización del Punto de Entrega
                </h6>

                <div class="row g-3 mb-4">
                    <div class="col-12 col-lg-5">
                        <div class="mb-3">
                            <label for="latitud" class="form-label fw-bold small text-dark">
                                Latitud <span class="text-danger">*</span>
                            </label>
                            <input type="text" 
                                   name="latitud" 
                                   id="latitud" 
                                   class="form-control font-monospace @error('latitud') is-invalid @enderror" 
                                   value="{{ old('latitud', $entrega->latitud ?? '19.2731') }}" 
                                   placeholder="Ej. 19.273100" 
                                   required readonly>
                            @error('latitud')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="longitud" class="form-label fw-bold small text-dark">
                                Longitud <span class="text-danger">*</span>
                            </label>
                            <input type="text" 
                                   name="longitud" 
                                   id="longitud" 
                                   class="form-control font-monospace @error('longitud') is-invalid @enderror" 
                                   value="{{ old('longitud', $entrega->longitud ?? '-99.4612') }}" 
                                   placeholder="Ej. -99.461200" 
                                   required readonly>
                            @error('longitud')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <p class="text-muted small">
                            <i class="bi bi-info-circle me-1"></i>Puedes arrastrar el marcador en el mapa para ajustar el punto de entrega exacto.
                        </p>
                    </div>

                    <div class="col-12 col-lg-7">
                        <div id="mapa-captura" class="shadow-sm border"></div>
                    </div>
                </div>

                <!-- Botones de Acción -->
                <div class="d-flex justify-content-end gap-2 mt-4 pt-3 border-top">
                    <a href="{{ route('entregas.index') }}" class="btn btn-light px-4 border fw-semibold">
                        Cancelar
                    </a>
                    <button type="submit" class="btn btn-warning px-4 fw-bold">
                        <i class="bi bi-pencil-square me-2"></i>Actualizar Entrega
                    </button>
                </div>

            </form>

        </div>
    </div>

</div>
@endsection

@push('scripts')
<!-- Leaflet JS -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script>
    // Referencia de la entrega actual
    const currentEntregaId = {{ $entrega->id }};

    function verificarHistorial(select) {
        const option = select.options[select.selectedIndex];
        const historialRaw = option.getAttribute('data-historial');
        const alertaContainer = document.getElementById('alerta-historial');
        const listaHistorial = document.getElementById('lista-historial');

        listaHistorial.innerHTML = '';

        if (historialRaw) {
            try {
                const historial = JSON.parse(historialRaw);

                // Filtrar el historial para omitir el registro actual que se está editando
                const otrosRegistros = historial.filter(e => e.id != currentEntregaId);

                if (otrosRegistros.length > 0) {
                    otrosRegistros.forEach(item => {
                        const li = document.createElement('li');
                        li.innerHTML = `<strong>${item.programa}</strong> — Entregado el ${item.fecha} por <em>${item.usuario}</em>`;
                        listaHistorial.appendChild(li);
                    });
                    alertaContainer.classList.remove('d-none');
                } else {
                    alertaContainer.classList.add('d-none');
                }
            } catch (e) {
                console.error("Error al parsear el historial del beneficiario", e);
                alertaContainer.classList.add('d-none');
            }
        } else {
            alertaContainer.classList.add('d-none');
        }
    }

    document.addEventListener('DOMContentLoaded', function () {
        // Ejecutar verificación del historial al cargar la página
        const selectBeneficiario = document.getElementById('beneficiario_id');
        if (selectBeneficiario && selectBeneficiario.value) {
            verificarHistorial(selectBeneficiario);
        }

        // Obtener valores iniciales de coordenadas
        let latInicial = parseFloat(document.getElementById('latitud').value) || 19.2731;
        let lngInicial = parseFloat(document.getElementById('longitud').value) || -99.4612;

        // Inicializar Mapa Leaflet
        const map = L.map('mapa-captura').setView([latInicial, lngInicial], 15);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);

        // Marcador Arrastrable
        let marker = L.marker([latInicial, lngInicial], { draggable: true }).addTo(map);

        function actualizarCoordenadas(lat, lng) {
            document.getElementById('latitud').value = lat.toFixed(6);
            document.getElementById('longitud').value = lng.toFixed(6);
        }

        // Evento al arrastrar el marcador
        marker.on('dragend', function (e) {
            const position = marker.getLatLng();
            actualizarCoordenadas(position.lat, position.lng);
        });

        // Evento al hacer clic en el mapa
        map.on('click', function (e) {
            marker.setLatLng(e.latlng);
            actualizarCoordenadas(e.latlng.lat, e.latlng.lng);
        });
    });
</script>
@endpush