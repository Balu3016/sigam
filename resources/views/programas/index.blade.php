@extends('layouts.app')

@section('title', 'Catálogo de Programas Sociales')

@section('content')
<div class="container-fluid px-0">

    <!-- Encabezado del Módulo -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
        <div>
            <h4 class="fw-bold text-dark mb-1">
                <i class="bi bi-journal-check text-success me-2"></i>Programas Sociales
            </h4>
            <p class="text-muted small mb-0">
                Gestión y catálogo oficial de apoyos y programas sociales del Municipio de Ocoyoacac.
            </p>
        </div>
        <div>
            <a href="{{ route('programas-sociales.create') }}" class="btn btn-success d-inline-flex align-items-center gap-2 shadow-sm">
                <i class="bi bi-plus-circle-fill"></i>
                <span>Nuevo Programa</span>
            </a>
        </div>
    </div>

    <!-- Tarjeta de Contenido / Tabla -->
    <div class="card border-0 shadow-sm rounded-3 overflow-hidden">
        
        <!-- Header con Buscador -->
        <div class="card-header bg-white py-3 border-bottom">
            <form method="GET" action="{{ route('programas-sociales.index') }}" class="row g-2 align-items-center">
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="input-group input-group-sm">
                        <span class="input-group-text bg-light border-end-0">
                            <i class="bi bi-search text-muted"></i>
                        </span>
                        <input type="text" name="search" class="form-control form-control-sm border-start-0 bg-light" 
                               placeholder="Buscar por código, nombre o categoría..." value="{{ $search }}">
                        @if($search)
                            <a href="{{ route('programas-sociales.index') }}" class="btn btn-outline-secondary btn-sm" title="Limpiar búsqueda">
                                <i class="bi bi-x-circle"></i>
                            </a>
                        @endif
                    </div>
                </div>
                <div class="col-auto">
                    <button type="submit" class="btn btn-primary btn-sm px-3">Buscar</button>
                </div>
            </form>
        </div>

        <!-- Tabla de Registros -->
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light border-bottom">
                        <tr class="text-uppercase font-monospace text-muted" style="font-size: 0.75rem;">
                            <th scope="col" class="ps-3 py-3">Código</th>
                            <th scope="col" class="py-3">Programa Social</th>
                            <th scope="col" class="py-3">Categoría</th>
                            <th scope="col" class="py-3">Modalidad / Frecuencia</th>
                            <th scope="col" class="py-3">Presupuesto Anual</th>
                            <th scope="col" class="py-3 text-center">Estado</th>
                            <th scope="col" class="pe-3 py-3 text-end">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($programas as $programa)
                            <tr>
                                <td class="ps-3">
                                    <span class="badge bg-dark-subtle text-dark border font-monospace">{{ $programa->codigo }}</span>
                                </td>
                                <td>
                                    <span class="fw-semibold text-dark d-block">{{ $programa->nombre }}</span>
                                    <small class="text-muted text-truncate d-inline-block" style="max-width: 250px;">
                                        {{ $programa->descripcion ?? 'Sin descripción disponible' }}
                                    </small>
                                </td>
                                <td>
                                    <span class="badge bg-secondary-subtle text-secondary border text-capitalize">
                                        {{ $programa->categoria }}
                                    </span>
                                </td>
                                <td>
                                    <div class="d-flex flex-column">
                                        <span class="small fw-bold text-capitalize text-dark">{{ $programa->tipo_apoyo }}</span>
                                        <small class="text-muted text-capitalize">{{ $programa->periodicidad }}</small>
                                    </div>
                                </td>
                                <td>
                                    <span class="font-monospace fw-semibold text-dark">
                                        ${{ number_format($programa->presupuesto_anual ?? 0, 2) }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    @if($programa->activo)
                                        <span class="badge bg-success rounded-pill px-2">Activo</span>
                                    @else
                                        <span class="badge bg-secondary rounded-pill px-2">Inactivo</span>
                                    @endif
                                </td>
                                <td class="pe-3 text-end">
                                    <div class="btn-group btn-group-sm" role="group">
                                        <!-- Ver Detalle -->
                                        <a href="{{ route('programas-sociales.show', $programa) }}" class="btn btn-outline-info" title="Ver Detalle">
                                            <i class="bi bi-eye"></i>
                                        </a>

                                        <!-- Editar -->
                                        <a href="{{ route('programas-sociales.edit', $programa) }}" class="btn btn-outline-primary" title="Editar">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>

                                        <!-- Activar / Desactivar (Borrado Lógico) -->
                                        <form method="POST" action="{{ route('programas-sociales.destroy', $programa) }}" class="d-inline"
                                              onsubmit="return confirm('¿Está seguro de cambiar el estado de este programa social?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn {{ $programa->activo ? 'btn-outline-danger' : 'btn-outline-success' }}" 
                                                    title="{{ $programa->activo ? 'Deshabilitar' : 'Activar' }}">
                                                <i class="bi {{ $programa->activo ? 'bi-toggle-on' : 'bi-toggle-off' }}"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-5 text-muted">
                                    <i class="bi bi-folder-x fs-1 d-block mb-2 text-secondary"></i>
                                    No se encontraron programas sociales registrados.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Paginación -->
        @if($programas->hasPages())
            <div class="card-footer bg-white py-3 border-top">
                <div class="d-flex justify-content-end">
                    {{ $programas->links('pagination::bootstrap-5') }}
                </div>
            </div>
        @endif
    </div>
</div>
@endsection