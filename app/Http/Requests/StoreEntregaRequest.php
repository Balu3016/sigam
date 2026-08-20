<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEntregaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'beneficiario_id' => ['required', 'exists:beneficiarios,id'],
            'programa_social_id' => ['required', 'exists:programas_sociales,id'],
            'fecha_entrega' => ['required', 'date', 'before_or_equal:today'],
            'cantidad' => ['required', 'integer', 'min:1'],
            'folio_acta' => ['nullable', 'string', 'max:50'],
            'observaciones' => ['nullable', 'string', 'max:500'],
        ];
    }

    public function attributes(): array
    {
        return [
            'beneficiario_id' => 'beneficiario',
            'programa_social_id' => 'programa social',
            'fecha_entrega' => 'fecha de entrega',
            'cantidad' => 'cantidad otorgada',
            'folio_acta' => 'folio / número de acta',
            'observaciones' => 'observaciones',
        ];
    }
}