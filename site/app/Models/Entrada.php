<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Entrada extends Model
{
    use HasFactory;

    /**
     * Los atributos que se pueden asignar masivamente.
     *
     * @var array
     */
    protected $fillable = ['nom', 'preu', 'quantitat', 'nominal', 'sessios_id'];

    /**
     * Obtiene la sesión asociada a la entrada.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function sessio()
    {
        return $this->belongsTo(Sessio::class, 'sessios_id');
    }

    /**
     * Obtiene las compras de entrada asociadas a la entrada.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function compraEntrada()
    {
        return $this->hasMany(CompraEntrada::class, 'entrada_id');
    }
}
