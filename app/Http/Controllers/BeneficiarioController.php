<?php

namespace App\Http\Controllers;

use App\Models\Beneficiario;
use App\Models\Localidad;
use App\Http\Requests\StoreBeneficiarioRequest;
use App\Http\Requests\UpdateBeneficiarioRequest;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class BeneficiarioController extends Controller
{
    /**
     * Muestra el Padrón Único de Beneficiarios con búsqueda y paginación.
     */
    public function index(Request $request): View
    {
        $search = trim($request->get('search', ''));

        // Se usa eager loading 'with' para evitar N+1 queries al cargar la localidad
        $beneficiarios = Beneficiario::with('localidad')
            ->when($search, function ($query, $search) {
                $query->where('curp', 'LIKE', "%{$search}%")
                      ->orWhere('nombre', 'LIKE', "%{$search}%")
                      ->orWhere('primer_apellido', 'LIKE', "%{$search}%")
                      ->orWhere('segundo_apellido', 'LIKE', "%{$search}%");
            })
            ->orderBy('id', 'desc')
            ->paginate(15)
            ->withQueryString();

        return view('beneficiarios.index', compact('beneficiarios', 'search'));
    }

    /**
     * Muestra el formulario para registrar un nuevo beneficiario.
     */
    public function create(): View
    {
        // Se envían solo las localidades activas para el selector
        $localidades = Localidad::activo()->orderBy('nombre', 'asc')->get();
        return view('beneficiarios.create', compact('localidades'));
    }

    /**
     * Almacena un beneficiario recién creado en la base de datos.
     */
    public function store(StoreBeneficiarioRequest $request): RedirectResponse
    {
        Beneficiario::create($request->validated());

        return redirect()
            ->route('beneficiarios.index')
            ->with('success', 'El ciudadano fue registrado exitosamente en el Padrón Único de Beneficiarios.');
    }

    /**
     * Muestra la ficha técnica detallada del ciudadano con su historial de entregas.
     */
    public function show(Beneficiario $beneficiario): View
    {
        // Cargamos la localidad y el historial completo de entregas con sus programas y capturistas
        $beneficiario->load([
            'localidad',
            'entregas.programaSocial',
            'entregas.usuario'
        ]);

        return view('beneficiarios.show', compact('beneficiario'));
    }

    /**
     * Muestra el formulario para editar un ciudadano existente.
     */
    public function edit(Beneficiario $beneficiario): View
    {
        $localidades = Localidad::activo()->orderBy('nombre', 'asc')->get();
        return view('beneficiarios.edit', compact('beneficiario', 'localidades'));
    }

    /**
     * Actualiza el registro del ciudadano en la base de datos.
     */
    public function update(UpdateBeneficiarioRequest $request, Beneficiario $beneficiario): RedirectResponse
    {
        $beneficiario->update($request->validated());

        return redirect()
            ->route('beneficiarios.index')
            ->with('success', 'El registro del ciudadano fue actualizado correctamente.');
    }

    /**
     * Cambia el estado del ciudadano en el padrón (Borrado Lógico SIGAM).
     */
    public function destroy(Beneficiario $beneficiario): RedirectResponse
    {
        $nuevoEstado = !$beneficiario->activo;
        $beneficiario->update(['activo' => $nuevoEstado]);

        $mensaje = $nuevoEstado 
            ? 'El ciudadano ha sido reactivado en el Padrón Único.' 
            : 'El ciudadano ha sido dado de baja (Inactivo) correctamente.';

        return redirect()
            ->route('beneficiarios.index')
            ->with('success', $mensaje);
    }
}