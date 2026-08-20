@extends('layouts.app')

@section('title', 'Asignar Apoyo Social')

@section('content')
<div class="container-fluid px-0">

    <!-- Encabezado del Formulario -->
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h4 class="fw-bold text-dark mb-1">
                <i class="bi bi-box-seam-fill text-success me-2"></i>Registrar Entrega de Apoyo Social
            </h4>
            <p class="text-muted small mb-0">
                Selecciona al beneficiario y el programa correspondiente para asentar el otorgamiento.
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
            
            <form action="{{ route('entregas.store') }}" method="POST">
                @csrf

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
                            <option value="" disabled {{ old('beneficiario_id') ? '' : 'selected' }}>Selecciona un ciudadano activo...</option>
                            @foreach($beneficiarios as $b)
                                @php
                                    $historial = $b->entregas->map(function($e) {
                                        $fecha = $e->fecha_entrega ? \Carbon\Carbon::parse($e->fecha_entrega)->format('d/m/Y') : 'Sin fecha';
                                        return [
                                            'programa' => $e->programaSocial->nombre ?? 'Programa General',
                                            'usuario' => $e->usuario->name ?? 'Sistema',
                                            'fecha' => $fecha
                                        ];
                                    });
                                @endphp
                                <option value="{{ $b->id }}" 
                                        {{ old('beneficiario_id') == $b->id ? 'selected' : '' }}
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
                                    <span>Atención: Este ciudadano ya cuenta con apoyos registrados:</span>
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
                            <option value="" disabled {{ old('programa_social_id') ? '' : 'selected' }}>Selecciona el programa origen...</option>
                            @foreach($programas as $p)
                                <option value="{{ $p->id }}" {{ old('programa_social_id') == $p->id ? 'selected' : '' }}>
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
                               value="{{ old('fecha_entrega', date('Y-m-d')) }}" 
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
                               value="{{ old('cantidad', 1) }}" 
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
                               value="{{ old('folio_acta') }}" 
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
                                  rows="3" 
                                  class="form-control @error('observaciones') is-invalid @enderror" 
                                  placeholder="Detalles sobre las condiciones de la entrega o documentación cotejada...">{{ old('observaciones') }}</textarea>
                        @error('observaciones')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                </div>

                <hr class="my-4 text-secondary">

                <!-- Botones de Acción -->
                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('entregas.index') }}" class="btn btn-light border">
                        Cancelar
                    </a>
                    <button type="submit" class="btn btn-success d-inline-flex align-items-center gap-2">
                        <i class="bi bi-check-lg"></i>
                        <span>Guardar y Asentar Entrega</span>
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>

@push('scripts')
<script>
function verificarHistorial(select) {
    if (!select || select.selectedIndex < 0) return;

    const option = select.options[select.selectedIndex];
    const rawData = option.getAttribute('data-historial');
    
    if (!rawData) {
        document.getElementById('alerta-historial').classList.add('d-none');
        return;
    }

    const historial = JSON.parse(rawData || '[]');
    const contenedor = document.getElementById('alerta-historial');
    const lista = document.getElementById('lista-historial');

    lista.innerHTML = '';

    if (historial.length > 0) {
        historial.forEach(item => {
            const li = document.createElement('li');
            li.innerHTML = `Recibió <strong>${item.programa}</strong> (Atendido por: <em>${item.usuario}</em>) el <strong>${item.fecha}</strong>`;
            lista.appendChild(li);
        });
        contenedor.classList.remove('d-none');
    } else {
        contenedor.classList.add('d-none');
    }
}

// Ejecutar al cargar la página si ya hay una opción seleccionada
document.addEventListener('DOMContentLoaded', function() {
    const selectBeneficiario = document.getElementById('beneficiario_id');
    if (selectBeneficiario && selectBeneficiario.value) {
        verificarHistorial(selectBeneficiario);
    }
});
</script>
@endpush
@endsection