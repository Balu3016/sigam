<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Builder;

class Beneficiario extends Model
{
    use HasFactory;

    /**
     * Tabla asociada en la base de datos.
     *
     * @var string
     */
    protected $table = 'beneficiarios';

    /**
     * Atributos asignables en masa.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'curp',
        'nombre',
        'primer_apellido',
        'segundo_apellido',
        'genero',
        'fecha_nacimiento',
        'telefono',
        'email',
        'direccion',
        'localidad_id',
        'estatus_socioeconomico',
        'activo',
    ];

    /**
     * Casts de atributos a tipos nativos.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'fecha_nacimiento' => 'date',
        'activo' => 'boolean',
    ];

    /**
     * Accessor para obtener el nombre completo formateado.
     *
     * @return string
     */
    public function getNombreCompletoAttribute(): string
    {
        return trim("{$this->nombre} {$this->primer_apellido} {$this->segundo_apellido}");
    }

    /**
     * Relación: Un beneficiario pertenece a una Localidad.
     *
     * @return BelongsTo
     */
    public function localidad(): BelongsTo
    {
        return $this->belongsTo(Localidad::class, 'localidad_id');
    }

    /**
     * Relación: Un beneficiario tiene muchos apoyos/entregas asignados (Presidencia, DIF, Bienestar).
     *
     * @return HasMany
     */
    public function entregas(): HasMany
    {
        return $this->hasMany(Entrega::class, 'beneficiario_id')->orderBy('fecha_entrega', 'desc');
    }

    /**
     * Scope local para filtrar registros activos (Borrado Lógico SIGAM).
     *
     * @param Builder $query
     * @return Builder
     */
    public function scopeActivo(Builder $query): Builder
    {
        return $query->where('activo', true);
    }
}