<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Compra extends Model
{
    use HasFactory;

    /**
     * Los atributos que se pueden asignar masivamente.
     *
     * @var array
     */
    protected $fillable = ['sessios_id', 'quantitat', 'mailComprador'];

    /**
     * Obtiene la sesión asociada a la compra.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function sessio()
    {
        return $this->belongsTo(Sessio::class, 'sessios_id');
    }

    /**
     * Obtiene las entradas compradas asociadas a la compra.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function compraEntrada()
    {
        return $this->hasMany(CompraEntrada::class, 'compra_id');
    }
}
