<section>
    <div class="d-flex align-items-center gap-2 mb-3">
        <i class="bi bi-person-gear text-success fs-4"></i>
        <div>
            <h5 class="fw-bold text-dark mb-0">Información del Perfil</h5>
            <small class="text-muted">Actualiza tu nombre de usuario y dirección de correo electrónico.</small>
        </div>
    </div>

    <hr class="my-3 text-muted opacity-25">

    <form method="post" action="{{ route('profile.update') }}">
        @csrf
        @method('patch')

        <div class="mb-3">
            <label for="name" class="form-label fw-semibold text-secondary small">Nombre Completo</label>
            <div class="input-group">
                <span class="input-group-text bg-light text-muted"><i class="bi bi-person"></i></span>
                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name">
            </div>
            @error('name')
                <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-4">
            <label for="email" class="form-label fw-semibold text-secondary small">Correo Electrónico</label>
            <div class="input-group">
                <span class="input-group-text bg-light text-muted"><i class="bi bi-envelope"></i></span>
                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $user->email) }}" required autocomplete="username">
            </div>
            @error('email')
                <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
        </div>

        <div class="d-flex justify-content-end">
            <button type="submit" class="btn btn-success fw-semibold px-4 rounded-3 d-inline-flex align-items-center gap-2 shadow-sm">
                <i class="bi bi-check-lg"></i>
                <span>Guardar Cambios</span>
            </button>
        </div>
    </form>
</section>