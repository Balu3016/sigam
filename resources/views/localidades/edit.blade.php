@extends('layouts.app')

@section('title', 'Editar Localidad')

@section('content')
<div class="container-fluid px-0">

    <!-- Encabezado del Formulario -->
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h4 class="fw-bold text-dark mb-1">
                <i class="bi bi-pencil-square text-primary me-2"></i>Editar Localidad
            </h4>
            <p class="text-muted small mb-0">
                Modifica los datos de la localidad: <strong class="text-dark">{{ $localidad->nombre }}</strong>
            </p>
        </div>
        <div>
            <a href="{{ route('localidades.index') }}" class="btn btn-outline-secondary d-inline-flex align-items-center gap-2">
                <i class="bi bi-arrow-left"></i>
                <span>Regresar al Catálogo</span>
            </a>
        </div>
    </div>

    <!-- Tarjeta del Formulario -->
    <div class="card border-0 shadow-sm rounded-3">
        <div class="card-body p-4">
            
            <form action="{{ route('localidades.update', ['localidad' => $localidad->id]) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row g-3">
                    
                    <!-- Nombre de la Localidad -->
                    <div class="col-12 col-md-6">
                        <label for="nombre" class="form-label fw-bold small text-dark">
                            Nombre de la Localidad / Colonia <span class="text-danger">*</span>
                        </label>
                        <input type="text" 
                               name="nombre" 
                               id="nombre" 
                               class="form-control @error('nombre') is-invalid @enderror" 
                               value="{{ old('nombre', $localidad->nombre) }}" 
                               required>
                        @error('nombre')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Código Postal -->
                    <div class="col-12 col-md-6">
                        <label for="codigo_postal" class="form-label fw-bold small text-dark">
                            Código Postal
                        </label>
                        <input type="text" 
                               name="codigo_postal" 
                               id="codigo_postal" 
                               class="form-control @error('codigo_postal') is-invalid @enderror" 
                               value="{{ old('codigo_postal', $localidad->codigo_postal) }}" 
                               maxlength="5">
                        <div class="form-text">Opcional. 5 dígitos numéricos.</div>
                        @error('codigo_postal')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Tipo de Localidad -->
                    <div class="col-12 col-md-6">
                        <label for="tipo" class="form-label fw-bold small text-dark">
                            Tipo de Asentamiento <span class="text-danger">*</span>
                        </label>
                        <select name="tipo" id="tipo" class="form-select @error('tipo') is-invalid @enderror" required>
                            <option value="cabecera" {{ old('tipo', $localidad->tipo) == 'cabecera' ? 'selected' : '' }}>Cabecera Municipal</option>
                            <option value="barrio" {{ old('tipo', $localidad->tipo) == 'barrio' ? 'selected' : '' }}>Barrio</option>
                            <option value="delegacion" {{ old('tipo', $localidad->tipo) == 'delegacion' ? 'selected' : '' }}>Delegación</option>
                            <option value="colonia" {{ old('tipo', $localidad->tipo) == 'colonia' ? 'selected' : '' }}>Colonia</option>
                            <option value="ejido" {{ old('tipo', $localidad->tipo) == 'ejido' ? 'selected' : '' }}>Ejido</option>
                            <option value="rancheria" {{ old('tipo', $localidad->tipo) == 'rancheria' ? 'selected' : '' }}>Ranchería</option>
                        </select>
                        @error('tipo')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Clasificación Zonal -->
                    <div class="col-12 col-md-6">
                        <label for="clasificacion_zonal" class="form-label fw-bold small text-dark">
                            Clasificación Zonal <span class="text-danger">*</span>
                        </label>
                        <select name="clasificacion_zonal" id="clasificacion_zonal" class="form-select @error('clasificacion_zonal') is-invalid @enderror" required>
                            <option value="urbana" {{ old('clasificacion_zonal', $localidad->clasificacion_zonal) == 'urbana' ? 'selected' : '' }}>Urbana</option>
                            <option value="semiurbana" {{ old('clasificacion_zonal', $localidad->clasificacion_zonal) == 'semiurbana' ? 'selected' : '' }}>Semiurbana</option>
                            <option value="rural" {{ old('clasificacion_zonal', $localidad->clasificacion_zonal) == 'rural' ? 'selected' : '' }}>Rural</option>
                        </select>
                        @error('clasificacion_zonal')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Estado Activo/Inactivo -->
                    <div class="col-12">
                        <div class="form-check form-switch mt-2">
                            <input class="form-check-input" type="checkbox" role="switch" id="activo" name="activo" value="1" {{ old('activo', $localidad->activo) ? 'checked' : '' }}>
                            <label class="form-check-label fw-bold small text-dark" for="activo">
                                Localidad activa en el catálogo oficial
                            </label>
                        </div>
                    </div>

                </div>

                <hr class="my-4 text-secondary">

                <!-- Botones de Acción -->
                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('localidades.index') }}" class="btn btn-light border">
                        Cancelar
                    </a>
                    <button type="submit" class="btn btn-primary d-inline-flex align-items-center gap-2">
                        <i class="bi bi-arrow-repeat"></i>
                        <span>Actualizar Localidad</span>
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>
@endsection