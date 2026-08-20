@extends('layouts.app')

@section('title', 'Expediente de Entrega de Apoyo')

@section('content')
<div class="container-fluid px-0">

    <!-- Encabezado -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
        <div>
            <h4 class="fw-bold text-dark mb-1">
                <i class="bi bi-receipt text-info me-2"></i>Comprobante Único de Entrega
            </h4>
            <p class="text-muted small mb-0">
                Detalle de auditoría de la entrega realizada en Ocoyoacac.
            </p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('entregas.index') }}" class="btn btn-outline-secondary d-inline-flex align-items-center gap-2">
                <i class="bi bi-arrow-left"></i>
                <span>Volver al Padrón</span>
            </a>
            <button onclick="window.print()" class="btn btn-outline-primary d-inline-flex align-items-center gap-2">
                <i class="bi bi-printer-fill"></i>
                <span>Imprimir Ficha</span>
            </button>
        </div>
    </div>

    <!-- Contenido Ficha -->
    <div class="row g-4">
        
        <div class="col-12 col-lg-8">
            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
                    <h6 class="fw-bold text-dark mb-0 font-monospace text-uppercase" style="font-size: 0.85rem;">
                        <i class="bi bi-info-circle-fill text-primary me-2"></i>Información del Registro
                    </h6>
                    <span class="badge bg-light text-dark border font-monospace px-3 py-2 fs-6">
                        Folio: {{ $entrega->folio_acta ?? 'SIN FOLIO' }}
                    </span>
                </div>
                <div class="card-body p-4">
                    <div class="row g-4">
                        
                        <!-- Beneficiario -->
                        <div class="col-12 col-md-6 border-end">
                            <h6 class="text-uppercase font-monospace text-muted small mb-2">Beneficiario</h6>
                            <span class="fw-bold text-dark fs-5 d-block">{{ $entrega->beneficiario->nombre_completo ?? 'N/A' }}</span>
                            <span class="badge bg-dark-subtle text-dark border font-monospace mt-1">
                                CURP: {{ $entrega->beneficiario->curp ?? 'N/A' }}
                            </span>
                            <div class="mt-2 text-muted small">
                                <i class="bi bi-geo-alt-fill text-danger me-1"></i>
                                Localidad: <strong>{{ $entrega->localidad->nombre ?? 'Sin Asignar' }}</strong>
                            </div>
                        </div>

                        <!-- Programa Social -->
                        <div class="col-12 col-md-6">
                            <h6 class="text-uppercase font-monospace text-muted small mb-2">Programa Social</h6>
                            <span class="fw-bold text-dark fs-5 d-block">{{ $entrega->programaSocial->nombre ?? 'N/A' }}</span>
                            <span class="badge bg-success-subtle text-success border mt-1">
                                {{ $entrega->programaSocial->clave ?? 'S/C' }}
                            </span>
                            <div class="mt-2 text-muted small">
                                Modalidad: <strong>{{ $entrega->programaSocial->modalidad ?? 'General' }}</strong>
                            </div>
                        </div>

                        <div class="col-12"><hr class="my-1 text-secondary"></div>

                        <!-- Detalle de la entrega -->
                        <div class="col-4">
                            <span class="text-muted small d-block">Fecha de Entrega:</span>
                            <strong class="text-dark fs-6">{{ $entrega->fecha_entrega->format('d/m/Y') }}</strong>
                        </div>
                        <div class="col-4">
                            <span class="text-muted small d-block">Cantidad Otorgada:</span>
                            <strong class="text-dark fs-6">{{ $entrega->cantidad }} Unidad(es)</strong>
                        </div>
                        <div class="col-4">
                            <span class="text-muted small d-block">Estatus del Registro:</span>
                            @if($entrega->estatus === 'entregado')
                                <span class="badge bg-success text-white">Entregado</span>
                            @else
                                <span class="badge bg-danger text-white">Cancelado</span>
                            @endif
                        </div>

                        <!-- Observaciones -->
                        <div class="col-12">
                            <span class="text-muted small d-block mb-1">Observaciones / Notas:</span>
                            <div class="p-3 bg-light rounded border text-secondary small">
                                {{ $entrega->observaciones ?? 'Sin observaciones registradas para esta entrega.' }}
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <!-- Trazabilidad / Auditoría -->
        <div class="col-12 col-lg-4">
            <div class="card border-0 shadow-sm rounded-3 bg-light">
                <div class="card-body p-4">
                    <h6 class="fw-bold text-dark text-uppercase font-monospace mb-3" style="font-size: 0.8rem;">
                        <i class="bi bi-shield-check me-2 text-success"></i>Trazabilidad Institucional
                    </h6>
                    <div class="small text-muted d-flex flex-column gap-2">
                        <div class="d-flex justify-content-between border-bottom pb-2">
                            <span>Registrado por:</span>
                            <strong class="text-dark">{{ $entrega->usuario->name ?? 'Sistema / Admin' }}</strong>
                        </div>
                        <div class="d-flex justify-content-between border-bottom pb-2">
                            <span>Fecha Captura:</span>
                            <strong class="text-dark">{{ $entrega->created_at ? $entrega->created_at->format('d/m/Y H:i') : 'N/A' }}</strong>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span>Última Modificación:</span>
                            <strong class="text-dark">{{ $entrega->updated_at ? $entrega->updated_at->format('d/m/Y H:i') : 'N/A' }}</strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection