@extends('layouts.app')

@section('title', 'Nueva Localidad')

@section('content')
<div class="container-fluid px-0">

    <!-- Encabezado del Formulario -->
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h4 class="fw-bold text-dark mb-1">
                <i class="bi bi-geo-alt-fill text-success me-2"></i>Registrar Nueva Localidad
            </h4>
            <p class="text-muted small mb-0">
                Agrega una nueva comunidad, barrio o colonia al catálogo territorial de Ocoyoacac.
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
            
            <form action="{{ route('localidades.store') }}" method="POST">
                @csrf

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
                               value="{{ old('nombre') }}" 
                               placeholder="Ej. Barrio de San Martin, Ejido San Mateo..." 
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
                               value="{{ old('codigo_postal') }}" 
                               placeholder="52740" 
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
                            <option value="" disabled {{ old('tipo') ? '' : 'selected' }}>Selecciona una opción...</option>
                            <option value="cabecera" {{ old('tipo') == 'cabecera' ? 'selected' : '' }}>Cabecera Municipal</option>
                            <option value="barrio" {{ old('tipo') == 'barrio' ? 'selected' : '' }}>Barrio</option>
                            <option value="delegacion" {{ old('tipo') == 'delegacion' ? 'selected' : '' }}>Delegación</option>
                            <option value="colonia" {{ old('tipo') == 'colonia' ? 'selected' : '' }}>Colonia</option>
                            <option value="ejido" {{ old('tipo') == 'ejido' ? 'selected' : '' }}>Ejido</option>
                            <option value="rancheria" {{ old('tipo') == 'rancheria' ? 'selected' : '' }}>Ranchería</option>
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
                            <option value="" disabled {{ old('clasificacion_zonal') ? '' : 'selected' }}>Selecciona una opción...</option>
                            <option value="urbana" {{ old('clasificacion_zonal') == 'urbana' ? 'selected' : '' }}>Urbana</option>
                            <option value="semiurbana" {{ old('clasificacion_zonal') == 'semiurbana' ? 'selected' : '' }}>Semiurbana</option>
                            <option value="rural" {{ old('clasificacion_zonal') == 'rural' ? 'selected' : '' }}>Rural</option>
                        </select>
                        @error('clasificacion_zonal')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                </div>

                <hr class="my-4 text-secondary">

                <!-- Botones de Acción -->
                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('localidades.index') }}" class="btn btn-light border">
                        Cancelar
                    </a>
                    <button type="submit" class="btn btn-success d-inline-flex align-items-center gap-2">
                        <i class="bi bi-save"></i>
                        <span>Guardar Localidad</span>
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>
@endsection