<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EsdevenimentImatge extends Model
{
    use HasFactory;

    /**
     * Los atributos que se pueden asignar masivamente.
     *
     * @var array
     */
    protected $fillable = ['esdeveniments_id', 'imatge'];

    /**
     * Obtiene el evento asociado a la imagen.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function esdeveniment()
    {
        return $this->belongsTo(Esdeveniment::class, 'esdeveniments_id');
    }
}
