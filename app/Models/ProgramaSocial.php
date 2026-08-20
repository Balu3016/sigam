<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class ProgramaSocial extends Model
{
    use HasFactory;

    /**
     * Nombre de la tabla asociada en la base de datos.
     *
     * @var string
     */
    protected $table = 'programas_sociales';

    /**
     * Los atributos que se pueden asignar de manera masiva.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'codigo',
        'nombre',
        'descripcion',
        'categoria',
        'presupuesto_anual',
        'tipo_apoyo',
        'periodicidad',
        'requisitos',
        'activo',
    ];

    /**
     * Atributos que deben ser convertidos a tipos nativos.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'presupuesto_anual' => 'decimal:2',
        'requisitos' => 'array',
        'activo' => 'boolean',
    ];

    /**
     * Scope local para filtrar únicamente registros activos (Borrado Lógico SIGAM).
     *
     * @param Builder $query
     * @return Builder
     */
    public function scopeActivo(Builder $query): Builder
    {
        return $query->where('activo', true);
    }
}