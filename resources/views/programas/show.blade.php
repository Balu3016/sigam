@extends('layouts.app')

@section('title', 'Detalle de Programa Social')

@section('content')
<div class="container-fluid px-0">

    <!-- Encabezado -->
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h4 class="fw-bold text-dark mb-1">
                <i class="bi bi-file-earmark-text text-info me-2"></i>Ficha Técnica del Programa
            </h4>
            <p class="text-muted small mb-0">
                Consulta los parámetros operativos, presupuesto y requisitos reglamentarios.
            </p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('programas-sociales.index') }}" class="btn btn-outline-secondary d-inline-flex align-items-center gap-2">
                <i class="bi bi-arrow-left"></i>
                <span>Regresar al Catálogo</span>
            </a>
            <a href="{{ route('programas-sociales.edit', $programa) }}" class="btn btn-primary d-inline-flex align-items-center gap-2">
                <i class="bi bi-pencil-square"></i>
                <span>Editar Programa</span>
            </a>
        </div>
    </div>

    <!-- Contenido Principal -->
    <div class="row g-4">
        
        <!-- Tarjeta de Información General -->
        <div class="col-12 col-lg-8">
            <div class="card border-0 shadow-sm rounded-3 h-100">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center border-bottom">
                    <span class="badge bg-dark-subtle text-dark border font-monospace px-3 py-2 fs-6">
                        {{ $programa->codigo }}
                    </span>
                    @if($programa->activo)
                        <span class="badge bg-success rounded-pill px-3 py-2">Estatus: Activo</span>
                    @else
                        <span class="badge bg-secondary rounded-pill px-3 py-2">Estatus: Inactivo</span>
                    @endif
                </div>

                <div class="card-body p-4">
                    <h3 class="fw-bold text-dark mb-3">{{ $programa->nombre }}</h3>
                    
                    <p class="text-secondary mb-4">
                        {{ $programa->descripcion ?? 'Este programa social no cuenta con una descripción detallada en la plataforma.' }}
                    </p>

                    <hr class="text-secondary my-4">

                    <h6 class="fw-bold text-dark text-uppercase font-monospace mb-3" style="font-size: 0.8rem;">
                        <i class="bi bi-list-check me-2 text-primary"></i>Requisitos Documentales Obligatorios
                    </h6>

                    @if(!empty($programa->requisitos) && is_array($programa->requisitos) && count($programa->requisitos) > 0)
                        <div class="list-group list-group-flush border rounded-3">
                            @foreach($programa->requisitos as $requisito)
                                <div class="list-group-item d-flex align-items-center gap-3 py-3">
                                    <i class="bi bi-check-circle-fill text-success fs-5"></i>
                                    <span class="text-dark fw-medium">{{ $requisito }}</span>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="alert alert-light border text-muted mb-0">
                            <i class="bi bi-exclamation-circle me-2"></i>No se han especificado requisitos documentales en este programa.
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Tarjeta de Métricas y Financiamiento -->
        <div class="col-12 col-lg-4">
            <div class="card border-0 shadow-sm rounded-3 h-100">
                <div class="card-header bg-white py-3 border-bottom">
                    <h6 class="fw-bold text-dark mb-0">Parámetros Operativos</h6>
                </div>
                <div class="card-body p-4 d-flex flex-column gap-3">
                    
                    <div>
                        <small class="text-muted text-uppercase font-monospace d-block" style="font-size: 0.7rem;">Presupuesto Asignado</small>
                        <span class="fs-4 fw-bold text-success font-monospace">
                            ${{ number_format($programa->presupuesto_anual ?? 0, 2) }}
                        </span>
                        <small class="text-muted d-block" style="font-size: 0.75rem;">Pesos Mexicanos (MXN)</small>
                    </div>

                    <hr class="my-1 text-secondary">

                    <div>
                        <small class="text-muted text-uppercase font-monospace d-block" style="font-size: 0.7rem;">Categoría Institucional</small>
                        <span class="badge bg-secondary-subtle text-secondary border text-capitalize px-3 py-2 mt-1">
                            {{ $programa->categoria }}
                        </span>
                    </div>

                    <div>
                        <small class="text-muted text-uppercase font-monospace d-block" style="font-size: 0.7rem;">Modalidad de Entrega</small>
                        <span class="fw-semibold text-dark text-capitalize d-block mt-1">
                            {{ $programa->tipo_apoyo }}
                        </span>
                    </div>

                    <div>
                        <small class="text-muted text-uppercase font-monospace d-block" style="font-size: 0.7rem;">Frecuencia del Apoyo</small>
                        <span class="fw-semibold text-dark text-capitalize d-block mt-1">
                            {{ $programa->periodicidad }}
                        </span>
                    </div>

                    <hr class="my-1 text-secondary">

                    <div class="bg-light p-3 rounded-3 mt-auto">
                        <div class="d-flex justify-content-between text-muted small mb-1">
                            <span>Registrado:</span>
                            <span class="fw-medium text-dark">{{ $programa->created_at ? $programa->created_at->format('d/m/Y') : 'N/A' }}</span>
                        </div>
                        <div class="d-flex justify-content-between text-muted small">
                            <span>Última Actualización:</span>
                            <span class="fw-medium text-dark">{{ $programa->updated_at ? $programa->updated_at->format('d/m/Y') : 'N/A' }}</span>
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div>
</div>
@endsection



