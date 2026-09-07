@extends('layouts.app')

@section('title', 'Mi Perfil')

@section('content')
<div class="container-fluid py-2">

    <!-- Notificaciones de éxito -->
    @if (session('status') === 'profile-updated')
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>Información de perfil actualizada correctamente.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if (session('status') === 'password-updated')
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
            <i class="bi bi-shield-check me-2"></i>Contraseña actualizada correctamente.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Tarjeta de Encabezado Principal -->
    <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden">
        <div class="card-body p-4 bg-white">
            <div class="d-flex align-items-center gap-3">
                <div class="bg-success bg-gradient text-white rounded-circle d-flex align-items-center justify-content-center fw-bold fs-3 shadow-sm" style="width: 64px; height: 64px;">
                    {{ strtoupper(substr(Auth::user()->name ?? 'U', 0, 1)) }}
                </div>
                <div>
                    <h4 class="fw-bold text-dark mb-0">{{ Auth::user()->name }}</h4>
                    <span class="badge bg-light text-secondary border mt-1">
                        <i class="bi bi-envelope-fill me-1"></i>{{ Auth::user()->email }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Navegación por Pestañas -->
    <div class="row">
        <div class="col-12">
            <ul class="nav nav-pills mb-4 gap-2 border-bottom pb-3" id="profileTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active fw-semibold rounded-pill px-4" id="info-tab" data-bs-toggle="pill" data-bs-target="#info-pane" type="button" role="tab">
                        <i class="bi bi-person-vcard me-2"></i>Información Personal
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link fw-semibold rounded-pill px-4" id="security-tab" data-bs-toggle="pill" data-bs-target="#security-pane" type="button" role="tab">
                        <i class="bi bi-shield-lock me-2"></i>Seguridad y Contraseña
                    </button>
                </li>
                <li class="nav-item ms-auto" role="presentation">
                    <button class="nav-link text-danger fw-semibold rounded-pill px-4" id="danger-tab" data-bs-toggle="pill" data-bs-target="#danger-pane" type="button" role="tab">
                        <i class="bi bi-exclamation-triangle me-2"></i>Zona de Riesgo
                    </button>
                </li>
            </ul>

            <div class="tab-content" id="profileTabsContent">
                <!-- Tab 1: Datos de Perfil -->
                <div class="tab-pane fade show active" id="info-pane" role="tabpanel">
                    <div class="card border-0 shadow-sm rounded-4 col-12 col-lg-8">
                        <div class="card-body p-4">
                            @include('profile.partials.update-profile-information-form')
                        </div>
                    </div>
                </div>

                <!-- Tab 2: Cambio de Contraseña -->
                <div class="tab-pane fade" id="security-pane" role="tabpanel">
                    <div class="card border-0 shadow-sm rounded-4 col-12 col-lg-8">
                        <div class="card-body p-4">
                            @include('profile.partials.update-password-form')
                        </div>
                    </div>
                </div>

                <!-- Tab 3: Eliminar Cuenta -->
                <div class="tab-pane fade" id="danger-pane" role="tabpanel">
                    <div class="card border-danger border-opacity-25 bg-danger bg-opacity-10 shadow-sm rounded-4 col-12 col-lg-8">
                        <div class="card-body p-4">
                            @include('profile.partials.delete-user-form')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection