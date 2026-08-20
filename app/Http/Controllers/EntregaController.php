<?php

namespace App\Http\Controllers;

use App\Models\Entrega;
use App\Models\Beneficiario;
use App\Models\ProgramaSocial;
use App\Http\Requests\StoreEntregaRequest;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class EntregaController extends Controller
{
    /**
     * Muestra el registro centralizado de entregas de apoyos.
     */
    public function index(Request $request): View
    {
        $search = trim($request->get('search', ''));

        $entregas = Entrega::with(['beneficiario', 'programaSocial', 'localidad', 'usuario'])
            ->when($search, function ($query, $search) {
                $query->whereHas('beneficiario', function ($q) use ($search) {
                    $q->where('curp', 'LIKE', "%{$search}%")
                      ->orWhere('nombre', 'LIKE', "%{$search}%")
                      ->orWhere('primer_apellido', 'LIKE', "%{$search}%");
                })->orWhereHas('programaSocial', function ($q) use ($search) {
                    $q->where('nombre', 'LIKE', "%{$search}%")
                      ->orWhere('clave', 'LIKE', "%{$search}%");
                })->orWhere('folio_acta', 'LIKE', "%{$search}%");
            })
            ->orderBy('fecha_entrega', 'desc')
            ->orderBy('id', 'desc')
            ->paginate(15)
            ->withQueryString();

        return view('entregas.index', compact('entregas', 'search'));
    }

    /**
     * Muestra el formulario para registrar la entrega de un apoyo.
     */
    public function create(): View
    {
        // Cargamos los beneficiarios activos junto con sus entregas previas para detección de duplicidad
        $beneficiarios = Beneficiario::activo()
            ->with(['entregas.programaSocial'])
            ->orderBy('primer_apellido', 'asc')
            ->get();

        $programas = ProgramaSocial::where('activo', true)
            ->orderBy('nombre', 'asc')
            ->get();

        return view('entregas.create', compact('beneficiarios', 'programas'));
    }

    /**
     * Almacena la asignación del apoyo social.
     */
    public function store(StoreEntregaRequest $request): RedirectResponse
    {
        $beneficiario = Beneficiario::findOrFail($request->beneficiario_id);

        Entrega::create([
            'beneficiario_id' => $request->beneficiario_id,
            'programa_social_id' => $request->programa_social_id,
            'localidad_id' => $beneficiario->localidad_id, // Se hereda la localidad del ciudadano
            'fecha_entrega' => $request->fecha_entrega,
            'cantidad' => $request->cantidad,
            'folio_acta' => $request->folio_acta,
            'observaciones' => $request->observaciones,
            'estatus' => 'entregado',
            'user_id' => Auth::id(),
        ]);

        return redirect()
            ->route('entregas.index')
            ->with('success', 'El apoyo social fue registrado correctamente en el Padrón de Entregas.');
    }

    /**
     * Muestra la ficha individual del recibo/acta de entrega.
     */
    public function show(Entrega $entrega): View
    {
        $entrega->load(['beneficiario', 'programaSocial', 'localidad', 'usuario']);
        return view('entregas.show', compact('entrega'));
    }

    /**
     * Cancelar una entrega / Apoyo (Borrado o conmutación lógica)
     */
    public function destroy(Entrega $entrega): RedirectResponse
    {
        $entrega->update(['estatus' => 'cancelado']);

        return redirect()
            ->route('entregas.index')
            ->with('success', 'El registro de entrega fue marcado como CANCELADO.');
    }
}