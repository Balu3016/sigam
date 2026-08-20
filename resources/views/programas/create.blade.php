@extends('layouts.app')

@section('title', 'Nuevo Programa Social')

@section('content')
<div class="container-fluid px-0">

    <!-- Encabezado del Formulario -->
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h4 class="fw-bold text-dark mb-1">
                <i class="bi bi-journal-plus text-success me-2"></i>Registrar Nuevo Programa Social
            </h4>
            <p class="text-muted small mb-0">
                Establece la clave oficial, categoría, presupuesto y requisitos del programa.
            </p>
        </div>
        <div>
            <a href="{{ route('programas-sociales.index') }}" class="btn btn-outline-secondary d-inline-flex align-items-center gap-2">
                <i class="bi bi-arrow-left"></i>
                <span>Regresar al Catálogo</span>
            </a>
        </div>
    </div>

    <!-- Tarjeta del Formulario -->
    <div class="card border-0 shadow-sm rounded-3">
        <div class="card-body p-4">
            
            <form action="{{ route('programas-sociales.store') }}" method="POST">
                @csrf

                <div class="row g-3">
                    
                    <!-- Código / Clave Institucional -->
                    <div class="col-12 col-md-4">
                        <label for="codigo" class="form-label fw-bold small text-dark">
                            Código / Clave del Programa <span class="text-danger">*</span>
                        </label>
                        <input type="text" 
                               name="codigo" 
                               id="codigo" 
                               class="form-control font-monospace @error('codigo') is-invalid @enderror" 
                               value="{{ old('codigo') }}" 
                               placeholder="Ej. PROG-2026-001" 
                               required>
                        @error('codigo')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Nombre del Programa -->
                    <div class="col-12 col-md-8">
                        <label for="nombre" class="form-label fw-bold small text-dark">
                            Nombre Oficial del Programa <span class="text-danger">*</span>
                        </label>
                        <input type="text" 
                               name="nombre" 
                               id="nombre" 
                               class="form-control @error('nombre') is-invalid @enderror" 
                               value="{{ old('nombre') }}" 
                               placeholder="Ej. Apoyo Alimentario a Familias Vulnerables" 
                               required>
                        @error('nombre')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Categoría -->
                    <div class="col-12 col-md-4">
                        <label for="categoria" class="form-label fw-bold small text-dark">
                            Categoría <span class="text-danger">*</span>
                        </label>
                        <select name="categoria" id="categoria" class="form-select @error('categoria') is-invalid @enderror" required>
                            <option value="" disabled {{ old('categoria') ? '' : 'selected' }}>Selecciona una categoría...</option>
                            <option value="alimentario" {{ old('categoria') == 'alimentario' ? 'selected' : '' }}>Alimentario</option>
                            <option value="economico" {{ old('categoria') == 'economico' ? 'selected' : '' }}>Económico</option>
                            <option value="educativo" {{ old('categoria') == 'educativo' ? 'selected' : '' }}>Educativo</option>
                            <option value="salud" {{ old('categoria') == 'salud' ? 'selected' : '' }}>Salud</option>
                            <option value="vivienda" {{ old('categoria') == 'vivienda' ? 'selected' : '' }}>Vivienda</option>
                            <option value="infraestructura" {{ old('categoria') == 'infraestructura' ? 'selected' : '' }}>Infraestructura</option>
                        </select>
                        @error('categoria')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Tipo de Apoyo -->
                    <div class="col-12 col-md-4">
                        <label for="tipo_apoyo" class="form-label fw-bold small text-dark">
                            Modalidad de Apoyo <span class="text-danger">*</span>
                        </label>
                        <select name="tipo_apoyo" id="tipo_apoyo" class="form-select @error('tipo_apoyo') is-invalid @enderror" required>
                            <option value="" disabled {{ old('tipo_apoyo') ? '' : 'selected' }}>Selecciona una opción...</option>
                            <option value="monetario" {{ old('tipo_apoyo') == 'monetario' ? 'selected' : '' }}>Monetario (Efectivo/Transferencia)</option>
                            <option value="especie" {{ old('tipo_apoyo') == 'especie' ? 'selected' : '' }}>Especie (Despensas, Materiales, etc.)</option>
                            <option value="servicio" {{ old('tipo_apoyo') == 'servicio' ? 'selected' : '' }}>Servicio (Atención médica, Capacitación)</option>
                        </select>
                        @error('tipo_apoyo')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Periodicidad -->
                    <div class="col-12 col-md-4">
                        <label for="periodicidad" class="form-label fw-bold small text-dark">
                            Periodicidad <span class="text-danger">*</span>
                        </label>
                        <select name="periodicidad" id="periodicidad" class="form-select @error('periodicidad') is-invalid @enderror" required>
                            <option value="" disabled {{ old('periodicidad') ? '' : 'selected' }}>Selecciona la frecuencia...</option>
                            <option value="unico" {{ old('periodicidad') == 'unico' ? 'selected' : '' }}>Apoyo Único</option>
                            <option value="mensual" {{ old('periodicidad') == 'mensual' ? 'selected' : '' }}>Mensual</option>
                            <option value="bimensual" {{ old('periodicidad') == 'bimensual' ? 'selected' : '' }}>Bimensual</option>
                            <option value="trimestral" {{ old('periodicidad') == 'trimestral' ? 'selected' : '' }}>Trimestral</option>
                            <option value="anual" {{ old('periodicidad') == 'anual' ? 'selected' : '' }}>Anual</option>
                        </select>
                        @error('periodicidad')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Presupuesto Anual -->
                    <div class="col-12 col-md-6">
                        <label for="presupuesto_anual" class="form-label fw-bold small text-dark">
                            Presupuesto Anual Asignado ($ MXN)
                        </label>
                        <div class="input-group">
                            <span class="input-group-text bg-light">$</span>
                            <input type="number" 
                                   step="0.01" 
                                   name="presupuesto_anual" 
                                   id="presupuesto_anual" 
                                   class="form-control @error('presupuesto_anual') is-invalid @enderror" 
                                   value="{{ old('presupuesto_anual') }}" 
                                   placeholder="0.00">
                        </div>
                        <div class="form-text">Opcional. Monto total presupuestado en pesos mexicanos.</div>
                        @error('presupuesto_anual')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Descripción del Programa -->
                    <div class="col-12 col-md-6">
                        <label for="descripcion" class="form-label fw-bold small text-dark">
                            Descripción / Objetivo del Programa
                        </label>
                        <textarea name="descripcion" 
                                  id="descripcion" 
                                  rows="2" 
                                  class="form-control @error('descripcion') is-invalid @enderror" 
                                  placeholder="Detalle el alcance y objetivo del programa...">{{ old('descripcion') }}</textarea>
                        @error('descripcion')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                </div>

                <hr class="my-4 text-secondary">

                <!-- Sección Dinámica de Requisitos Documentales -->
                <div class="mb-3">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <label class="form-label fw-bold small text-dark mb-0">
                            Requisitos Documentales
                        </label>
                        <button type="button" id="btn-add-requisito" class="btn btn-outline-success btn-sm d-inline-flex align-items-center gap-1">
                            <i class="bi bi-plus-lg"></i>
                            <span>Agregar Requisito</span>
                        </button>
                    </div>
                    <p class="text-muted small mb-3">Define los documentos requeridos para la inscripción de beneficiarios.</p>

                    <div id="requisitos-container" class="d-flex flex-column gap-2">
                        <!-- Primer campo de requisito por defecto -->
                        <div class="input-group input-group-sm requisito-item">
                            <span class="input-group-text bg-light"><i class="bi bi-file-earmark-text text-muted"></i></span>
                            <input type="text" name="requisitos[]" class="form-control" placeholder="Ej. Identificación Oficial Vigente (INE)" value="Identificación Oficial Vigente (INE)">
                            <button type="button" class="btn btn-outline-danger btn-remove-requisito" title="Eliminar">
                                <i class="bi bi-trash"></i>
                            </button>
                        </div>
                        <div class="input-group input-group-sm requisito-item">
                            <span class="input-group-text bg-light"><i class="bi bi-file-earmark-text text-muted"></i></span>
                            <input type="text" name="requisitos[]" class="form-control" placeholder="Ej. Comprobante de Domicilio de Ocoyoacac" value="Comprobante de Domicilio reciente de Ocoyoacac">
                            <button type="button" class="btn btn-outline-danger btn-remove-requisito" title="Eliminar">
                                <i class="bi bi-trash"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <hr class="my-4 text-secondary">

                <!-- Botones de Acción -->
                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('programas-sociales.index') }}" class="btn btn-light border">
                        Cancelar
                    </a>
                    <button type="submit" class="btn btn-success d-inline-flex align-items-center gap-2">
                        <i class="bi bi-save"></i>
                        <span>Guardar Programa</span>
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>

<!-- Script JS para manejar dinámicamente la lista de Requisitos -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const container = document.getElementById('requisitos-container');
        const btnAdd = document.getElementById('btn-add-requisito');

        // Agregar nuevo campo
        btnAdd.addEventListener('click', function () {
            const newItem = document.createElement('div');
            newItem.className = 'input-group input-group-sm requisito-item';
            newItem.innerHTML = `
                <span class="input-group-text bg-light"><i class="bi bi-file-earmark-text text-muted"></i></span>
                <input type="text" name="requisitos[]" class="form-control" placeholder="Ej. Clave Única de Registro de Población (CURP)">
                <button type="button" class="btn btn-outline-danger btn-remove-requisito" title="Eliminar">
                    <i class="bi bi-trash"></i>
                </button>
            `;
            container.appendChild(newItem);
        });

        // Eliminar campo específico
        container.addEventListener('click', function (e) {
            if (e.target.closest('.btn-remove-requisito')) {
                const items = container.querySelectorAll('.requisito-item');
                if (items.length > 1) {
                    e.target.closest('.requisito-item').remove();
                } else {
                    alert('Debe conservar al menos un campo de requisito.');
                }
            }
        });
    });
</script>
@endsection