@extends('layouts.app')

@section('title', 'Expediente del Ciudadano')

@section('content')
<div class="container-fluid px-0">

    <!-- Encabezado de la Ficha -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
        <div>
            <div class="d-flex align-items-center gap-2 mb-1">
                <h4 class="fw-bold text-dark mb-0">
                    <i class="bi bi-person-vcard text-success me-2"></i>Expediente Único del Ciudadano
                </h4>
                @if($beneficiario->activo)
                    <span class="badge bg-success rounded-pill">Activo</span>
                @else
                    <span class="badge bg-secondary rounded-pill">Inactivo</span>
                @endif
            </div>
            <p class="text-muted small mb-0">
                Registro de Control Interdependencias - Ayuntamiento de Ocoyoacac.
            </p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('beneficiarios.index') }}" class="btn btn-outline-secondary d-inline-flex align-items-center gap-2">
                <i class="bi bi-arrow-left"></i>
                <span>Volver al Padrón</span>
            </a>
            <a href="{{ route('beneficiarios.edit', $beneficiario) }}" class="btn btn-primary d-inline-flex align-items-center gap-2">
                <i class="bi bi-pencil-square"></i>
                <span>Editar Expediente</span>
            </a>
        </div>
    </div>

    <div class="row g-4">
        
        <!-- Tarjeta Principal: Información General -->
        <div class="col-12 col-lg-8">
            <div class="card border-0 shadow-sm rounded-3 mb-4">
                <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
                    <h6 class="fw-bold text-dark mb-0 font-monospace text-uppercase" style="font-size: 0.85rem;">
                        <i class="bi bi-person-badge text-primary me-2"></i>Datos Personales y Demográficos
                    </h6>
                    <span class="badge bg-dark-subtle text-dark font-monospace px-3 py-2 border fs-6">
                        {{ $beneficiario->curp }}
                    </span>
                </div>
                <div class="card-body p-4">
                    <div class="row g-3">
                        <div class="col-12 col-md-6">
                            <span class="text-muted small d-block">Nombre Completo:</span>
                            <span class="fw-bold text-dark fs-5">{{ $beneficiario->nombre_completo }}</span>
                        </div>
                        <div class="col-6 col-md-3">
                            <span class="text-muted small d-block">Género:</span>
                            <span class="fw-semibold text-dark">
                                {{ $beneficiario->genero == 'M' ? 'Masculino' : ($beneficiario->genero == 'F' ? 'Femenino' : 'Otro') }}
                            </span>
                        </div>
                        <div class="col-6 col-md-3">
                            <span class="text-muted small d-block">Fecha de Nacimiento:</span>
                            <span class="fw-semibold text-dark">
                                {{ $beneficiario->fecha_nacimiento ? \Carbon\Carbon::parse($beneficiario->fecha_nacimiento)->format('d/m/Y') : 'No registrada' }}
                            </span>
                        </div>

                        <div class="col-12"><hr class="my-2 text-secondary"></div>

                        <!-- Ubicación -->
                        <div class="col-12 col-md-6">
                            <span class="text-muted small d-block">Localidad / Delegación:</span>
                            <span class="fw-semibold text-dark">
                                <i class="bi bi-geo-alt-fill text-danger me-1"></i>
                                {{ $beneficiario->localidad->nombre ?? 'Sin Asignar' }}
                                @if(isset($beneficiario->localidad->tipo))
                                    <span class="badge bg-light text-secondary border ms-1">{{ $beneficiario->localidad->tipo }}</span>
                                @endif
                            </span>
                        </div>
                        <div class="col-12 col-md-6">
                            <span class="text-muted small d-block">Estatus Socioeconómico:</span>
                            @switch($beneficiario->estatus_socioeconomico)
                                @case('pobreza_extrema')
                                    <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-3 py-2">Pobreza Extrema</span>
                                    @break
                                @case('pobreza_moderada')
                                    <span class="badge bg-warning-subtle text-warning-emphasis border border-warning-subtle px-3 py-2">Pobreza Moderada</span>
                                    @break
                                @case('vulnerable')
                                    <span class="badge bg-info-subtle text-info-emphasis border border-info-subtle px-3 py-2">Vulnerable</span>
                                    @break
                                @default
                                    <span class="badge bg-secondary-subtle text-secondary border px-3 py-2">General / Sin Vulnerabilidad</span>
                            @endswitch
                        </div>

                        <div class="col-12">
                            <span class="text-muted small d-block">Dirección Particular:</span>
                            <span class="fw-semibold text-dark">
                                {{ $beneficiario->direccion ?? 'Sin dirección registrada.' }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Historial Transversal de Apoyos Recibidos (Presidencia / DIF / Bienestar) -->
            <div class="card border-0 shadow-sm rounded-3 mt-4">
                <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
                    <h6 class="fw-bold text-dark mb-0 font-monospace text-uppercase" style="font-size: 0.85rem;">
                        <i class="bi bi-clock-history text-primary me-2"></i>Historial Transversal de Apoyos
                    </h6>
                    <span class="badge bg-primary-subtle text-primary border font-monospace">
                        Total: {{ $beneficiario->entregas ? $beneficiario->entregas->count() : 0 }} apoyo(s)
                    </span>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light border-bottom">
                                <tr class="text-uppercase font-monospace text-muted" style="font-size: 0.75rem;">
                                    <th class="ps-3 py-3">Fecha</th>
                                    <th class="py-3">Programa / Apoyo</th>
                                    <th class="py-3">Dependencia Responsable</th>
                                    <th class="py-3 text-center">Cant.</th>
                                    <th class="py-3 text-center">Estatus</th>
                                    <th class="pe-3 py-3 text-end">Folio</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($beneficiario->entregas as $entrega)
                                    <tr>
                                        <td class="ps-3 fw-semibold text-dark">
                                            {{ $entrega->fecha_entrega ? \Carbon\Carbon::parse($entrega->fecha_entrega)->format('d/m/Y') : 'N/A' }}
                                        </td>
                                        <td>
                                            <strong class="text-dark d-block">{{ $entrega->programaSocial->nombre ?? 'Sin programa asignado' }}</strong>
                                            <small class="text-muted">{{ $entrega->programaSocial->clave ?? '' }}</small>
                                        </td>
                                        <td>
                                            <span class="badge bg-secondary-subtle text-secondary-emphasis border">
                                                <i class="bi bi-building me-1"></i>{{ $entrega->programaSocial->dependencia_responsable ?? 'Desarrollo Social' }}
                                            </span>
                                        </td>
                                        <td class="text-center fw-bold">{{ $entrega->cantidad ?? 1 }}</td>
                                        <td class="text-center">
                                            @if(($entrega->estatus ?? 'entregado') === 'entregado')
                                                <span class="badge bg-success-subtle text-success border">Entregado</span>
                                            @else
                                                <span class="badge bg-danger-subtle text-danger border">Cancelado</span>
                                            @endif
                                        </td>
                                        <td class="pe-3 text-end font-monospace text-muted small">
                                            {{ $entrega->folio_acta ?? 'S/F' }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-4 text-muted">
                                            <i class="bi bi-journal-x d-block fs-3 mb-1"></i>
                                            Este beneficiario no cuenta con apoyos registrados en Presidencia, DIF o Bienestar.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tarjeta Lateral: Contacto y Trazabilidad -->
        <div class="col-12 col-lg-4">
            <!-- Contacto -->
            <div class="card border-0 shadow-sm rounded-3 mb-4">
                <div class="card-header bg-white py-3 border-bottom">
                    <h6 class="fw-bold text-dark mb-0 font-monospace text-uppercase" style="font-size: 0.85rem;">
                        <i class="bi bi-telephone-fill text-primary me-2"></i>Canales de Contacto
                    </h6>
                </div>
                <div class="card-body p-3">
                    <ul class="list-group list-group-flush small">
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0 py-2 border-bottom">
                            <span class="text-muted"><i class="bi bi-telephone me-2"></i>Teléfono:</span>
                            <span class="fw-semibold text-dark">{{ $beneficiario->telefono ?? 'No registrado' }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0 py-2 border-0">
                            <span class="text-muted"><i class="bi bi-envelope me-2"></i>Correo:</span>
                            <span class="fw-semibold text-dark text-truncate" style="max-width: 180px;">
                                {{ $beneficiario->email ?? 'No registrado' }}
                            </span>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Metadatos de Auditoría -->
            <div class="card border-0 shadow-sm rounded-3 bg-light">
                <div class="card-body p-3">
                    <h6 class="fw-bold text-dark text-uppercase font-monospace mb-2" style="font-size: 0.75rem;">
                        <i class="bi bi-clock-history me-1"></i>Trazabilidad del Registro
                    </h6>
                    <div class="small text-muted">
                        <div class="d-flex justify-content-between mb-1">
                            <span>Fecha de Registro:</span>
                            <strong class="text-dark">{{ $beneficiario->created_at ? \Carbon\Carbon::parse($beneficiario->created_at)->format('d/m/Y H:i') : 'N/A' }}</strong>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span>Última Actualización:</span>
                            <strong class="text-dark">{{ $beneficiario->updated_at ? \Carbon\Carbon::parse($beneficiario->updated_at)->format('d/m/Y H:i') : 'N/A' }}</strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection