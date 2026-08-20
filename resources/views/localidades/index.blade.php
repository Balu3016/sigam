@extends('layouts.app')

@section('title', 'Catálogo de Localidades')

@section('content')
<div class="container-fluid px-0">

    <!-- Encabezado del Módulo -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
        <div>
            <h4 class="fw-bold text-dark mb-1">
                <i class="bi bi-geo-alt-fill text-success me-2"></i>Catálogo de Localidades
            </h4>
            <p class="text-muted small mb-0">
                Administración de la división territorial oficial del Municipio de Ocoyoacac.
            </p>
        </div>
        <div>
            <a href="{{ route('localidades.create') }}" class="btn btn-success d-inline-flex align-items-center gap-2 shadow-sm">
                <i class="bi bi-plus-circle-fill"></i>
                <span>Nueva Localidad</span>
            </a>
        </div>
    </div>

    <!-- Tarjeta de Contenido / Tabla -->
    <div class="card border-0 shadow-sm rounded-3 overflow-hidden">
        
        <!-- Header de la Tarjeta (Buscador) -->
        <div class="card-header bg-white py-3 border-bottom">
            <form method="GET" action="{{ route('localidades.index') }}" class="row g-2 align-items-center">
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="input-group input-group-sm">
                        <span class="input-group-text bg-light border-end-0">
                            <i class="bi bi-search text-muted"></i>
                        </span>
                        <input type="text" name="search" class="form-control form-control-sm border-start-0 bg-light" 
                               placeholder="Buscar por nombre o código postal..." value="{{ $search }}">
                        @if($search)
                            <a href="{{ route('localidades.index') }}" class="btn btn-outline-secondary btn-sm" title="Limpiar búsqueda">
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

        <!-- Cuerpo de la Tarjeta (Tabla) -->
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light border-bottom">
                        <tr class="text-uppercase font-monospace text-muted" style="font-size: 0.75rem;">
                            <th scope="col" class="ps-3 py-3">#</th>
                            <th scope="col" class="py-3">Nombre / Colonia</th>
                            <th scope="col" class="py-3">Tipo</th>
                            <th scope="col" class="py-3">C.P.</th>
                            <th scope="col" class="py-3">Clasificación Zonal</th>
                            <th scope="col" class="py-3 text-center">Estado</th>
                            <th scope="col" class="pe-3 py-3 text-end">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($localidades as $localidad)
                            <tr>
                                <td class="ps-3 fw-bold text-muted">{{ $localidad->id }}</td>
                                <td>
                                    <span class="fw-semibold text-dark">{{ $localidad->nombre }}</span>
                                </td>
                                <td>
                                    <span class="badge bg-light text-dark border">
                                        {{ ucfirst($localidad->tipo) }}
                                    </span>
                                </td>
                                <td>
                                    <span class="font-monospace text-muted">
                                        {{ $localidad->codigo_postal ?? 'N/A' }}
                                    </span>
                                </td>
                                <td>
                                    @if($localidad->clasificacion_zonal === 'urbana')
                                        <span class="badge bg-success-subtle text-success border border-success-subtle">Urbana</span>
                                    @elseif($localidad->clasificacion_zonal === 'semiurbana')
                                        <span class="badge bg-info-subtle text-info border border-info-subtle">Semiurbana</span>
                                    @else
                                        <span class="badge bg-warning-subtle text-warning border border-warning-subtle">Rural</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if($localidad->activo)
                                        <span class="badge bg-success rounded-pill px-2">Activa</span>
                                    @else
                                        <span class="badge bg-secondary rounded-pill px-2">Inactiva</span>
                                    @endif
                                </td>
                                <td class="pe-3 text-end">
                                    <div class="btn-group btn-group-sm" role="group">
                                        <!-- Editar -->
                                        <a href="{{ route('localidades.edit', $localidad) }}" class="btn btn-outline-primary" title="Editar">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>

                                        <!-- Activar / Desactivar (Borrado Lógico) -->
                                        <form method="POST" action="{{ route('localidades.destroy', $localidad) }}" class="d-inline"
                                              onsubmit="return confirm('¿Está seguro de cambiar el estado de esta localidad?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn {{ $localidad->activo ? 'btn-outline-danger' : 'btn-outline-success' }}" 
                                                    title="{{ $localidad->activo ? 'Deshabilitar' : 'Activar' }}">
                                                <i class="bi {{ $localidad->activo ? 'bi-toggle-on' : 'bi-toggle-off' }}"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-5 text-muted">
                                    <i class="bi bi-geo-alt fs-1 d-block mb-2 text-secondary"></i>
                                    No se encontraron localidades registradas en el catálogo.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pie de la Tarjeta (Paginación) -->
        @if($localidades->hasPages())
            <div class="card-footer bg-white py-3 border-top">
                <div class="d-flex justify-content-end">
                    {{ $localidades->links('pagination::bootstrap-5') }}
                </div>
            </div>
        @endif
    </div>
</div>
@endsection