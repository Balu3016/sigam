<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateBeneficiarioRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Prepara los datos antes de la validación.
     */
    protected function prepareForValidation(): void
    {
        if ($this->has('curp')) {
            $this->merge([
                'curp' => strtoupper(trim($this->curp)),
            ]);
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $beneficiarioId = $this->route('beneficiario') 
            ? $this->route('beneficiario')->id 
            : $this->route('beneficiario');

        return [
            'curp' => [
                'required', 
                'string', 
                'size:18', 
                'regex:/^[A-Z]{4}\d{6}[HM][A-Z]{5}[A-Z\d]\d$/',
                Rule::unique('beneficiarios', 'curp')->ignore($beneficiarioId)
            ],
            'nombre' => ['required', 'string', 'max:100'],
            'primer_apellido' => ['required', 'string', 'max:100'],
            'segundo_apellido' => ['nullable', 'string', 'max:100'],
            'genero' => ['required', 'string', Rule::in(['M', 'F', 'Otro'])],
            'fecha_nacimiento' => ['nullable', 'date', 'before:today'],
            'telefono' => ['nullable', 'string', 'max:15'],
            'email' => ['nullable', 'email', 'max:150'],
            'direccion' => ['nullable', 'string'],
            'localidad_id' => ['required', 'exists:localidades,id'],
            'estatus_socioeconomico' => ['required', 'string', Rule::in(['vulnerable', 'pobreza_moderada', 'pobreza_extrema', 'general'])],
            'activo' => ['nullable', 'boolean'],
        ];
    }

    /**
     * Nombres personalizados de atributos.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'curp' => 'CURP',
            'nombre' => 'nombre(s)',
            'primer_apellido' => 'primer apellido',
            'segundo_apellido' => 'segundo apellido',
            'genero' => 'género',
            'fecha_nacimiento' => 'fecha de nacimiento',
            'telefono' => 'teléfono de contacto',
            'email' => 'correo electrónico',
            'direccion' => 'dirección',
            'localidad_id' => 'localidad / delegación',
            'estatus_socioeconomico' => 'estatus socioeconómico',
            'activo' => 'estado activo',
        ];
    }

    /**
     * Mensajes de error personalizados.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'curp.unique' => 'La :attribute ingresada ya se encuentra registrada en otro beneficiario.',
            'curp.size' => 'La :attribute debe tener exactamente 18 caracteres.',
            'curp.regex' => 'El formato de la :attribute es inválido según la estructura oficial.',
            'localidad_id.exists' => 'La :attribute seleccionada no existe en el catálogo.',
        ];
    }
}