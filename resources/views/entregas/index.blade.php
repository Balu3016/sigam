@extends('layouts.app')

@section('title', 'Padrón de Entrega de Apoyos')

@section('content')
<div class="container-fluid px-0">

    <!-- Encabezado del Módulo -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
        <div>
            <h4 class="fw-bold text-dark mb-1">
                <i class="bi bi-box-seam-fill text-info me-2"></i>Padrón Único de Entrega de Apoyos
            </h4>
            <p class="text-muted small mb-0">
                Registro de asignación directa de beneficios sociales a la ciudadanía de Ocoyoacac.
            </p>
        </div>
        <div>
            <a href="{{ route('entregas.create') }}" class="btn btn-success d-inline-flex align-items-center gap-2 shadow-sm">
                <i class="bi bi-plus-circle-fill"></i>
                <span>Registrar Nueva Entrega</span>
            </a>
        </div>
    </div>

    <!-- Alert de éxito -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Tarjeta de Contenido / Tabla -->
    <div class="card border-0 shadow-sm rounded-3 overflow-hidden">
        
        <!-- Header con Buscador -->
        <div class="card-header bg-white py-3 border-bottom">
            <form method="GET" action="{{ route('entregas.index') }}" class="row g-2 align-items-center">
                <div class="col-12 col-md-6 col-lg-5">
                    <div class="input-group input-group-sm">
                        <span class="input-group-text bg-light border-end-0">
                            <i class="bi bi-search text-muted"></i>
                        </span>
                        <input type="text" name="search" class="form-control form-control-sm border-start-0 bg-light" 
                               placeholder="Buscar por CURP, beneficiario, programa o folio..." value="{{ $search }}">
                        @if($search)
                            <a href="{{ route('entregas.index') }}" class="btn btn-outline-secondary btn-sm" title="Limpiar búsqueda">
                                <i class="bi bi-x-circle"></i>
                            </a>
                        @endif
                    </div>
                </div>
                <div class="col-auto">
                    <button type="submit" class="btn btn-primary btn-sm px-3">Buscar Registros</button>
                </div>
            </form>
        </div>

        <!-- Tabla de Entregas -->
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light border-bottom">
                        <tr class="text-uppercase font-monospace text-muted" style="font-size: 0.75rem;">
                            <th scope="col" class="ps-3 py-3">Fecha / Folio</th>
                            <th scope="col" class="py-3">Beneficiario / CURP</th>
                            <th scope="col" class="py-3">Programa Social</th>
                            <th scope="col" class="py-3">Localidad</th>
                            <th scope="col" class="py-3 text-center">Cantidad</th>
                            <th scope="col" class="py-3 text-center">Estatus</th>
                            <th scope="col" class="pe-3 py-3 text-end">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($entregas as $entrega)
                            <tr>
                                <td class="ps-3">
                                    <span class="fw-semibold text-dark d-block">
                                        {{ $entrega->fecha_entrega->format('d/m/Y') }}
                                    </span>
                                    <small class="text-muted font-monospace">
                                        {{ $entrega->folio_acta ?? 'S/F' }}
                                    </small>
                                </td>
                                <td>
                                    <span class="fw-semibold text-dark d-block">
                                        {{ $entrega->beneficiario->nombre_completo ?? 'N/A' }}
                                    </span>
                                    <span class="badge bg-dark-subtle text-dark border font-monospace px-1 py-0 fs-7">
                                        {{ $entrega->beneficiario->curp ?? 'Sin CURP' }}
                                    </span>
                                </td>
                                <td>
                                    <span class="fw-medium text-dark d-block">
                                        {{ $entrega->programaSocial->nombre ?? 'N/A' }}
                                    </span>
                                    <small class="text-muted">
                                        {{ $entrega->programaSocial->clave ?? '' }}
                                    </small>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center gap-1 text-secondary">
                                        <i class="bi bi-geo-alt-fill text-danger small"></i>
                                        <span class="small fw-medium text-dark">
                                            {{ $entrega->localidad->nombre ?? 'Sin Asignar' }}
                                        </span>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-light text-dark border px-3 py-2 fw-bold">
                                        {{ $entrega->cantidad }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    @if($entrega->estatus === 'entregado')
                                        <span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1">
                                            <i class="bi bi-check-circle-fill me-1"></i>Entregado
                                        </span>
                                    @elseif($entrega->estatus === 'pendiente')
                                        <span class="badge bg-warning-subtle text-warning-emphasis border border-warning-subtle px-2 py-1">
                                            <i class="bi bi-clock-history me-1"></i>Pendiente
                                        </span>
                                    @else
                                        <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-2 py-1">
                                            <i class="bi bi-x-circle-fill me-1"></i>Cancelado
                                        </span>
                                    @endif
                                </td>
                                <td class="pe-3 text-end">
                                    <div class="btn-group btn-group-sm" role="group">
                                        <!-- Ver Ficha / Recibo -->
                                        <a href="{{ route('entregas.show', $entrega) }}" class="btn btn-outline-info" title="Ver Expediente de Entrega">
                                            <i class="bi bi-eye"></i>
                                        </a>

                                        <!-- Cancelar / Dar de baja la entrega -->
                                        @if($entrega->estatus !== 'cancelado')
                                            <form method="POST" action="{{ route('entregas.destroy', $entrega) }}" class="d-inline"
                                                  onsubmit="return confirm('¿Desea marcar como CANCELADA esta entrega?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-outline-danger" title="Cancelar Entrega">
                                                    <i class="bi bi-x-circle"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-5 text-muted">
                                    <i class="bi bi-box-seam fs-1 d-block mb-2 text-secondary"></i>
                                    No se han registrado entregas de apoyos sociales en el sistema.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Paginación -->
        @if($entregas->hasPages())
            <div class="card-footer bg-white py-3 border-top">
                <div class="d-flex justify-content-end">
                    {{ $entregas->links('pagination::bootstrap-5') }}
                </div>
            </div>
        @endif
    </div>
</div>
@endsection