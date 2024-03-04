<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CompraEntrada extends Model
{
    use HasFactory;

    /**
     * Los atributos que se pueden asignar masivamente.
     *
     * @var array
     */
    protected $fillable = ['compra_id', 'nomComprador', 'dni', 'numeroIdentificador', 'tel', 'entrada_id'];

    /**
     * Verifica si el número identificador es único en la tabla de compra_entradas.
     *
     * @param  string  $num
     * @return bool
     */
    public static function isNumeroIdentificadorUnique($num)
    {
        $count = DB::table('compra_entradas')->where('numeroIdentificador', $num)->count();
        return $count === 0;
    }

    /**
     * Obtiene la entrada asociada a la compra de entrada.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function entrada()
    {
        return $this->belongsTo(Entrada::class, 'entrada_id');
    }

    /**
     * Obtiene la compra asociada a la compra de entrada.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function compras()
    {
        return $this->belongsTo(Compra::class, 'compra_id');
    }

    /**
     * Obtiene las entradas compradas asociadas a una compra.
     *
     * @param  int  $id
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function getEntrades($id)
    {
        return self::with('entrada')
            ->where('compra_id', $id)
            ->get();
    }
}
