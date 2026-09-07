@extends('layouts.app')

@section('title', 'Gestión de Entregas de Apoyos')

@section('content')
<div class="container-fluid py-4">
    {{-- Encabezado de la Sección --}}
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
        <div>
            <h1 class="h3 mb-1 text-gray-800 fw-bold">Entregas de Apoyos Sociales</h1>
            <p class="text-muted mb-0 small">Registro y seguimiento de actas de entrega a beneficiarios</p>
        </div>
        <div>
            <a href="{{ route('entregas.create') }}" class="btn btn-primary d-inline-flex align-items-center gap-2 shadow-sm">
                <i class="bi bi-plus-lg"></i>
                <span>Nueva Entrega</span>
            </a>
        </div>
    </div>

    {{-- Alertas de Sesión --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- Tarjeta Principal --}}
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white py-3">
            <form action="{{ route('entregas.index') }}" method="GET" class="row g-2 align-items-center">
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0 text-muted">
                            <i class="bi bi-search"></i>
                        </span>
                        <input type="text" 
                               name="search" 
                               class="form-control bg-light border-start-0" 
                               placeholder="Buscar folio, beneficiario, CURP, programa o usuario..." 
                               value="{{ request('search') }}">
                    </div>
                </div>
                <div class="col-12 col-md-auto d-flex gap-2">
                    <button type="submit" class="btn btn-secondary text-nowrap">
                        Filtrar
                    </button>
                    @if(request('search'))
                        <a href="{{ route('entregas.index') }}" class="btn btn-outline-secondary text-nowrap">
                            Limpiar
                        </a>
                    @endif
                </div>
            </form>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th scope="col" class="ps-3">Folio</th>
                            <th scope="col">Beneficiario</th>
                            <th scope="col">Programa</th>
                            <th scope="col" class="text-center">Cant.</th>
                            <th scope="col">Localidad / Ubicación</th>
                            <th scope="col" class="text-center">Fecha</th>
                            <th scope="col">Capturado Por</th>
                            <th scope="col" class="text-center">Estatus</th>
                            <th scope="col" class="text-end pe-3">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($entregas as $entrega)
                            <tr>
                                {{-- Folio --}}
                                <td class="ps-3 fw-semibold text-primary">
                                    {{ $entrega->folio_acta }}
                                </td>

                                {{-- Beneficiario --}}
                                <td>
                                    <div class="fw-bold text-dark">
                                        {{ $entrega->beneficiario->nombre_completo ?? 'N/A' }}
                                    </div>
                                    <small class="text-muted d-block fs-7">
                                        CURP: {{ $entrega->beneficiario->curp ?? 'Sin registro' }}
                                    </small>
                                </td>

                                {{-- Programa --}}
                                <td>
                                    <span class="badge bg-info-subtle text-info border border-info-subtle px-2 py-1">
                                        {{ $entrega->programaSocial->nombre ?? 'N/A' }}
                                    </span>
                                </td>

                                {{-- Cantidad --}}
                                <td class="text-center fw-bold text-dark">
                                    {{ number_format($entrega->cantidad) }}
                                </td>

                                {{-- Localidad y Geolocalización --}}
                                <td>
                                    <div class="text-secondary fw-semibold">
                                        {{ $entrega->localidad->nombre ?? 'N/A' }}
                                    </div>
                                    @if($entrega->latitud && $entrega->longitud)
                                        <a href="https://www.google.com/maps?q={{ $entrega->latitud }},{{ $entrega->longitud }}" 
                                           target="_blank" 
                                           class="btn btn-link btn-sm p-0 text-decoration-none text-danger small">
                                            <i class="bi bi-geo-alt-fill"></i> Ver en Mapa
                                        </a>
                                    @else
                                        <small class="text-muted fs-7">Sin GPS</small>
                                    @endif
                                </td>

                                {{-- Fecha --}}
                                <td class="text-center text-nowrap">
                                    {{ optional($entrega->fecha_entrega)->format('d/m/Y') ?? 'N/A' }}
                                </td>

                                {{-- Capturado Por --}}
                                <td>
                                    <span class="small text-secondary">
                                        <i class="bi bi-person me-1"></i>{{ $entrega->usuario->name ?? 'Sistema' }}
                                    </span>
                                </td>

                                {{-- Estatus --}}
                                <td class="text-center">
                                    @if(($entrega->estatus ?? 'Entregado') === 'Entregado')
                                        <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill px-3">
                                            Entregado
                                        </span>
                                    @elseif(($entrega->estatus) === 'Pendiente')
                                        <span class="badge bg-warning-subtle text-warning border border-warning-subtle rounded-pill px-3">
                                            Pendiente
                                        </span>
                                    @else
                                        <span class="badge bg-danger-subtle text-danger border border-danger-subtle rounded-pill px-3">
                                            Cancelado
                                        </span>
                                    @endif
                                </td>

                                {{-- Acciones --}}
                                <td class="text-end pe-3 text-nowrap">
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('entregas.show', $entrega->id) }}" 
                                           class="btn btn-sm btn-outline-secondary" 
                                           title="Ver Detalle">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="{{ route('entregas.edit', $entrega->id) }}" 
                                           class="btn btn-sm btn-outline-primary" 
                                           title="Editar">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form action="{{ route('entregas.destroy', $entrega->id) }}" 
                                              method="POST" 
                                              class="d-inline"
                                              onsubmit="return confirm('¿Está seguro de cancelar/eliminar esta entrega?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="btn btn-sm btn-outline-danger" 
                                                    title="Eliminar">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center py-5 text-muted">
                                    <i class="bi bi-inbox fs-1 d-block mb-2 text-secondary opacity-50"></i>
                                    @if(request('search'))
                                        No se encontraron entregas que coincidan con <strong>"{{ request('search') }}"</strong>.
                                    @else
                                        No hay registros de entregas sociales en la base de datos.
                                    @endif
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Paginación --}}
        @if($entregas->hasPages())
            <div class="card-footer bg-white border-top-0 py-3">
                <div class="d-flex justify-content-center">
                    {{ $entregas->appends(request()->query())->links('pagination::bootstrap-5') }}
                </div>
            </div>
        @endif
    </div>
</div>
@endsection