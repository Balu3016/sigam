<section>
    <div class="d-flex align-items-center gap-2 mb-3">
        <i class="bi bi-shield-lock text-warning fs-4"></i>
        <div>
            <h5 class="fw-bold text-dark mb-0">Actualizar Contraseña</h5>
            <small class="text-muted">Asegúrate de utilizar una combinación de caracteres segura.</small>
        </div>
    </div>

    <hr class="my-3 text-muted opacity-25">

    <form method="post" action="{{ route('password.update') }}">
        @csrf
        @method('put')

        <div class="mb-3">
            <label for="update_password_current_password" class="form-label fw-semibold text-secondary small">Contraseña Actual</label>
            <div class="input-group">
                <span class="input-group-text bg-light text-muted"><i class="bi bi-key"></i></span>
                <input type="password" class="form-control @error('current_password', 'updatePassword') is-invalid @enderror" id="update_password_current_password" name="current_password" autocomplete="current-password">
            </div>
            @error('current_password', 'updatePassword')
                <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="update_password_password" class="form-label fw-semibold text-secondary small">Nueva Contraseña</label>
            <div class="input-group">
                <span class="input-group-text bg-light text-muted"><i class="bi bi-lock"></i></span>
                <input type="password" class="form-control @error('password', 'updatePassword') is-invalid @enderror" id="update_password_password" name="password" autocomplete="new-password">
            </div>
            @error('password', 'updatePassword')
                <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-4">
            <label for="update_password_password_confirmation" class="form-label fw-semibold text-secondary small">Confirmar Nueva Contraseña</label>
            <div class="input-group">
                <span class="input-group-text bg-light text-muted"><i class="bi bi-check-circle"></i></span>
                <input type="password" class="form-control @error('password_confirmation', 'updatePassword') is-invalid @enderror" id="update_password_password_confirmation" name="password_confirmation" autocomplete="new-password">
            </div>
            @error('password_confirmation', 'updatePassword')
                <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
        </div>

        <div class="d-flex justify-content-end">
            <button type="submit" class="btn btn-warning text-dark fw-semibold px-4 rounded-3 d-inline-flex align-items-center gap-2 shadow-sm">
                <i class="bi bi-shield-check"></i>
                <span>Actualizar Contraseña</span>
            </button>
        </div>
    </form>
</section>