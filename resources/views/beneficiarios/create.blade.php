@extends('layouts.app')

@section('title', 'Registrar Ciudadano')

@section('content')
<div class="container-fluid px-0">

    <!-- Encabezado del Formulario -->
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h4 class="fw-bold text-dark mb-1">
                <i class="bi bi-person-plus-fill text-success me-2"></i>Alta en el Padrón Único de Beneficiarios
            </h4>
            <p class="text-muted small mb-0">
                Registra a un ciudadano para el control interdependencias y asignación de apoyos sociales.
            </p>
        </div>
        <div>
            <a href="{{ route('beneficiarios.index') }}" class="btn btn-outline-secondary d-inline-flex align-items-center gap-2">
                <i class="bi bi-arrow-left"></i>
                <span>Regresar al Padrón</span>
            </a>
        </div>
    </div>

    <!-- Tarjeta del Formulario -->
    <div class="card border-0 shadow-sm rounded-3">
        <div class="card-body p-4">
            
            <form action="{{ route('beneficiarios.store') }}" method="POST">
                @csrf

                <!-- Sección: Identificación Oficial -->
                <h6 class="fw-bold text-dark text-uppercase font-monospace mb-3" style="font-size: 0.8rem;">
                    <i class="bi bi-card-heading me-2 text-primary"></i>Datos de Identificación Oficial
                </h6>

                <div class="row g-3 mb-4">
                    
                    <!-- CURP -->
                    <div class="col-12 col-md-4">
                        <label for="curp" class="form-label fw-bold small text-dark">
                            CURP <span class="text-danger">*</span>
                        </label>
                        <input type="text" 
                               name="curp" 
                               id="curp" 
                               maxlength="18"
                               class="form-control font-monospace text-uppercase @error('curp') is-invalid @enderror" 
                               value="{{ old('curp') }}" 
                               placeholder="18 Caracteres (Ej. ABCD900101HDFXXX01)" 
                               required>
                        @error('curp')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @else
                            <div class="form-text">Llave única de control interdependencias.</div>
                        @enderror
                    </div>

                    <!-- Nombre(s) -->
                    <div class="col-12 col-md-8">
                        <label for="nombre" class="form-label fw-bold small text-dark">
                            Nombre(s) <span class="text-danger">*</span>
                        </label>
                        <input type="text" 
                               name="nombre" 
                               id="nombre" 
                               class="form-control @error('nombre') is-invalid @enderror" 
                               value="{{ old('nombre') }}" 
                               placeholder="Ej. Juan José" 
                               required>
                        @error('nombre')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Primer Apellido -->
                    <div class="col-12 col-md-4">
                        <label for="primer_apellido" class="form-label fw-bold small text-dark">
                            Primer Apellido (Paterno) <span class="text-danger">*</span>
                        </label>
                        <input type="text" 
                               name="primer_apellido" 
                               id="primer_apellido" 
                               class="form-control @error('primer_apellido') is-invalid @enderror" 
                               value="{{ old('primer_apellido') }}" 
                               placeholder="Ej. Pérez" 
                               required>
                        @error('primer_apellido')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Segundo Apellido -->
                    <div class="col-12 col-md-4">
                        <label for="segundo_apellido" class="form-label fw-bold small text-dark">
                            Segundo Apellido (Materno)
                        </label>
                        <input type="text" 
                               name="segundo_apellido" 
                               id="segundo_apellido" 
                               class="form-control @error('segundo_apellido') is-invalid @enderror" 
                               value="{{ old('segundo_apellido') }}" 
                               placeholder="Ej. López">
                        @error('segundo_apellido')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Género -->
                    <div class="col-12 col-md-2">
                        <label for="genero" class="form-label fw-bold small text-dark">
                            Género <span class="text-danger">*</span>
                        </label>
                        <select name="genero" id="genero" class="form-select @error('genero') is-invalid @enderror" required>
                            <option value="" disabled {{ old('genero') ? '' : 'selected' }}>Selecciona...</option>
                            <option value="M" {{ old('genero') == 'M' ? 'selected' : '' }}>Masculino</option>
                            <option value="F" {{ old('genero') == 'F' ? 'selected' : '' }}>Femenino</option>
                            <option value="Otro" {{ old('genero') == 'Otro' ? 'selected' : '' }}>Otro</option>
                        </select>
                        @error('genero')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Fecha de Nacimiento -->
                    <div class="col-12 col-md-2">
                        <label for="fecha_nacimiento" class="form-label fw-bold small text-dark">
                            Fecha Nacimiento
                        </label>
                        <input type="date" 
                               name="fecha_nacimiento" 
                               id="fecha_nacimiento" 
                               class="form-control @error('fecha_nacimiento') is-invalid @enderror" 
                               value="{{ old('fecha_nacimiento') }}">
                        @error('fecha_nacimiento')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                </div>

                <hr class="my-4 text-secondary">

                <!-- Sección: Ubicación y Contacto -->
                <h6 class="fw-bold text-dark text-uppercase font-monospace mb-3" style="font-size: 0.8rem;">
                    <i class="bi bi-geo-alt-fill me-2 text-primary"></i>Ubicación Territorial y Contacto
                </h6>

                <div class="row g-3 mb-4">
                    
                    <!-- Localidad -->
                    <div class="col-12 col-md-6">
                        <label for="localidad_id" class="form-label fw-bold small text-dark">
                            Localidad / Delegación <span class="text-danger">*</span>
                        </label>
                        <select name="localidad_id" id="localidad_id" class="form-select @error('localidad_id') is-invalid @enderror" required>
                            <option value="" disabled {{ old('localidad_id') ? '' : 'selected' }}>Selecciona la localidad de residencia...</option>
                            @foreach($localidades as $localidad)
                                <option value="{{ $localidad->id }}" {{ old('localidad_id') == $localidad->id ? 'selected' : '' }}>
                                    {{ $localidad->nombre }} ({{ $localidad->tipo }})
                                </option>
                            @endforeach
                        </select>
                        @error('localidad_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Teléfono -->
                    <div class="col-12 col-md-3">
                        <label for="telefono" class="form-label fw-bold small text-dark">
                            Teléfono de Contacto
                        </label>
                        <input type="text" 
                               name="telefono" 
                               id="telefono" 
                               class="form-control @error('telefono') is-invalid @enderror" 
                               value="{{ old('telefono') }}" 
                               placeholder="Ej. 7221234567">
                        @error('telefono')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div class="col-12 col-md-3">
                        <label for="email" class="form-label fw-bold small text-dark">
                            Correo Electrónico
                        </label>
                        <input type="email" 
                               name="email" 
                               id="email" 
                               class="form-control @error('email') is-invalid @enderror" 
                               value="{{ old('email') }}" 
                               placeholder="ejemplo@correo.com">
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Dirección -->
                    <div class="col-12">
                        <label for="direccion" class="form-label fw-bold small text-dark">
                            Dirección Completa (Calle, No. Ext, No. Int, Colonia)
                        </label>
                        <textarea name="direccion" 
                                  id="direccion" 
                                  rows="2" 
                                  class="form-control @error('direccion') is-invalid @enderror" 
                                  placeholder="Ej. Calle Hidalgo #45, Col. Centro">{{ old('direccion') }}</textarea>
                        @error('direccion')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                </div>

                <hr class="my-4 text-secondary">

                <!-- Sección: Clasificación Socioeconómica -->
                <h6 class="fw-bold text-dark text-uppercase font-monospace mb-3" style="font-size: 0.8rem;">
                    <i class="bi bi-bar-chart-steps me-2 text-primary"></i>Evaluación Socioeconómica
                </h6>

                <div class="row g-3">
                    
                    <!-- Estatus Socioeconómico -->
                    <div class="col-12 col-md-6">
                        <label for="estatus_socioeconomico" class="form-label fw-bold small text-dark">
                            Prioridad / Estatus Socioeconómico <span class="text-danger">*</span>
                        </label>
                        <select name="estatus_socioeconomico" id="estatus_socioeconomico" class="form-select @error('estatus_socioeconomico') is-invalid @enderror" required>
                            <option value="vulnerable" {{ old('estatus_socioeconomico') == 'vulnerable' ? 'selected' : '' }}>Vulnerable</option>
                            <option value="pobreza_moderada" {{ old('estatus_socioeconomico') == 'pobreza_moderada' ? 'selected' : '' }}>Pobreza Moderada</option>
                            <option value="pobreza_extrema" {{ old('estatus_socioeconomico') == 'pobreza_extrema' ? 'selected' : '' }}>Pobreza Extrema</option>
                            <option value="general" {{ old('estatus_socioeconomico') == 'general' ? 'selected' : '' }}>General / Sin Vulnerabilidad</option>
                        </select>
                        @error('estatus_socioeconomico')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                </div>

                <hr class="my-4 text-secondary">

                <!-- Botones de Acción -->
                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('beneficiarios.index') }}" class="btn btn-light border">
                        Cancelar
                    </a>
                    <button type="submit" class="btn btn-success d-inline-flex align-items-center gap-2">
                        <i class="bi bi-save"></i>
                        <span>Registrar en Padrón</span>
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>
@endsection