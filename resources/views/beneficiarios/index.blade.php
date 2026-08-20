@extends('layouts.app')

@section('title', 'Padrón Único de Beneficiarios')

@section('content')
<div class="container-fluid px-0">

    <!-- Encabezado del Módulo -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
        <div>
            <h4 class="fw-bold text-dark mb-1">
                <i class="bi bi-people-fill text-success me-2"></i>Padrón Único de Beneficiarios
            </h4>
            <p class="text-muted small mb-0">
                Registro centralizado de ciudadanos y control interdependencias del Municipio de Ocoyoacac.
            </p>
        </div>
        <div>
            <a href="{{ route('beneficiarios.create') }}" class="btn btn-success d-inline-flex align-items-center gap-2 shadow-sm">
                <i class="bi bi-person-plus-fill"></i>
                <span>Registrar Ciudadano</span>
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
            <form method="GET" action="{{ route('beneficiarios.index') }}" class="row g-2 align-items-center">
                <div class="col-12 col-md-6 col-lg-5">
                    <div class="input-group input-group-sm">
                        <span class="input-group-text bg-light border-end-0">
                            <i class="bi bi-search text-muted"></i>
                        </span>
                        <input type="text" name="search" class="form-control form-control-sm border-start-0 bg-light" 
                               placeholder="Buscar por CURP, nombre o apellidos..." value="{{ $search }}">
                        @if($search)
                            <a href="{{ route('beneficiarios.index') }}" class="btn btn-outline-secondary btn-sm" title="Limpiar búsqueda">
                                <i class="bi bi-x-circle"></i>
                            </a>
                        @endif
                    </div>
                </div>
                <div class="col-auto">
                    <button type="submit" class="btn btn-primary btn-sm px-3">Buscar en Padrón</button>
                </div>
            </form>
        </div>

        <!-- Tabla de Registros -->
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light border-bottom">
                        <tr class="text-uppercase font-monospace text-muted" style="font-size: 0.75rem;">
                            <th scope="col" class="ps-3 py-3">CURP</th>
                            <th scope="col" class="py-3">Nombre Completo</th>
                            <th scope="col" class="py-3">Localidad / Delegación</th>
                            <th scope="col" class="py-3">Contacto</th>
                            <th scope="col" class="py-3">Prioridad Socioeconómica</th>
                            <th scope="col" class="py-3 text-center">Estado</th>
                            <th scope="col" class="pe-3 py-3 text-end">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($beneficiarios as $beneficiario)
                            <tr>
                                <td class="ps-3">
                                    <span class="badge bg-dark-subtle text-dark border font-monospace px-2 py-1 fs-6">
                                        {{ $beneficiario->curp }}
                                    </span>
                                </td>
                                <td>
                                    <span class="fw-semibold text-dark d-block">{{ $beneficiario->nombre_completo }}</span>
                                    <small class="text-muted">
                                        Género: {{ $beneficiario->genero == 'M' ? 'Masculino' : ($beneficiario->genero == 'F' ? 'Femenino' : 'Otro') }}
                                        @if($beneficiario->fecha_nacimiento)
                                            • {{ $beneficiario->fecha_nacimiento->format('d/m/Y') }}
                                        @endif
                                    </small>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center gap-1 text-secondary">
                                        <i class="bi bi-geo-alt-fill text-danger small"></i>
                                        <span class="small fw-medium text-dark">{{ $beneficiario->localidad->nombre ?? 'Sin Asignar' }}</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex flex-column small">
                                        <span class="text-dark"><i class="bi bi-telephone text-muted me-1"></i>{{ $beneficiario->telefono ?? 'Sin teléfono' }}</span>
                                        @if($beneficiario->email)
                                            <span class="text-muted text-truncate" style="max-width: 180px;">
                                                <i class="bi bi-envelope text-muted me-1"></i>{{ $beneficiario->email }}
                                            </span>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    @switch($beneficiario->estatus_socioeconomico)
                                        @case('pobreza_extrema')
                                            <span class="badge bg-danger-subtle text-danger border border-danger-subtle">Pobreza Extrema</span>
                                            @break
                                        @case('pobreza_moderada')
                                            <span class="badge bg-warning-subtle text-warning-emphasis border border-warning-subtle">Pobreza Moderada</span>
                                            @break
                                        @case('vulnerable')
                                            <span class="badge bg-info-subtle text-info-emphasis border border-info-subtle">Vulnerable</span>
                                            @break
                                        @default
                                            <span class="badge bg-secondary-subtle text-secondary border">General</span>
                                    @endswitch
                                </td>
                                <td class="text-center">
                                    @if($beneficiario->activo)
                                        <span class="badge bg-success rounded-pill px-2">Activo</span>
                                    @else
                                        <span class="badge bg-secondary rounded-pill px-2">Inactivo</span>
                                    @endif
                                </td>
                                <td class="pe-3 text-end">
                                    <div class="btn-group btn-group-sm" role="group">
                                        <!-- Ver Expediente -->
                                        <a href="{{ route('beneficiarios.show', $beneficiario) }}" class="btn btn-outline-info" title="Ver Expediente">
                                            <i class="bi bi-eye"></i>
                                        </a>

                                        <!-- Editar -->
                                        <a href="{{ route('beneficiarios.edit', $beneficiario) }}" class="btn btn-outline-primary" title="Editar">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>

                                        <!-- Conmutar Estado (Borrado Lógico) -->
                                        <form method="POST" action="{{ route('beneficiarios.destroy', $beneficiario) }}" class="d-inline"
                                              onsubmit="return confirm('¿Desea cambiar el estado del ciudadano en el padrón?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn {{ $beneficiario->activo ? 'btn-outline-danger' : 'btn-outline-success' }}" 
                                                    title="{{ $beneficiario->activo ? 'Dar de Baja' : 'Reactivar' }}">
                                                <i class="bi {{ $beneficiario->activo ? 'bi-toggle-on' : 'bi-toggle-off' }}"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-5 text-muted">
                                    <i class="bi bi-person-exclamation fs-1 d-block mb-2 text-secondary"></i>
                                    No se encontraron ciudadanos registrados en el Padrón Único.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Paginación -->
        @if($beneficiarios->hasPages())
            <div class="card-footer bg-white py-3 border-top">
                <div class="d-flex justify-content-end">
                    {{ $beneficiarios->links('pagination::bootstrap-5') }}
                </div>
            </div>
        @endif
    </div>
</div>
@endsection