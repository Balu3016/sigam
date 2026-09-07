<section>
    <div class="d-flex align-items-center gap-2 mb-3">
        <i class="bi bi-exclamation-triangle-fill text-danger fs-4"></i>
        <div>
            <h5 class="fw-bold text-danger mb-0">Eliminar Cuenta</h5>
            <small class="text-danger text-opacity-75">Una vez eliminada la cuenta, todos sus recursos y datos serán borrados permanentemente.</small>
        </div>
    </div>

    <hr class="my-3 text-danger opacity-25">

    <p class="text-secondary small mb-4">
        Antes de proceder, asegúrate de haber respaldado la información importante asociada a esta cuenta.
    </p>

    <!-- Botón Modal -->
    <button type="button" class="btn btn-danger fw-semibold px-4 rounded-3 d-inline-flex align-items-center gap-2 shadow-sm" data-bs-toggle="modal" data-bs-target="#confirmUserDeletionModal">
        <i class="bi bi-trash-fill"></i>
        <span>Eliminar Mi Cuenta</span>
    </button>

    <!-- Modal Bootstrap de Confirmación -->
    <div class="modal fade" id="confirmUserDeletionModal" tabindex="-1" aria-labelledby="confirmUserDeletionModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg rounded-4">
                <form method="post" action="{{ route('profile.destroy') }}">
                    @csrf
                    @method('delete')

                    <div class="modal-header border-bottom-0 pb-0">
                        <h5 class="modal-title fw-bold text-dark" id="confirmUserDeletionModalLabel">¿Estás seguro de eliminar tu cuenta?</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body py-3">
                        <p class="text-muted small mb-3">
                            Ingresa tu contraseña para confirmar que deseas eliminar permanentemente la cuenta.
                        </p>

                        <div class="mb-2">
                            <input type="password" class="form-control @error('password', 'userDeletion') is-invalid @enderror" id="password" name="password" placeholder="Tu contraseña actual">
                            @error('password', 'userDeletion')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="modal-footer border-top-0 pt-0">
                        <button type="button" class="btn btn-light fw-semibold rounded-3" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-danger fw-semibold rounded-3">Sí, Eliminar Cuenta</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>