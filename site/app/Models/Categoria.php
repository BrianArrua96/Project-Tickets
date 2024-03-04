<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Categoria extends Model
{
    use HasFactory;

    protected $fillable = ['tipus'];

    protected $table = 'categories';

    /**
     * Define la relación de la categoría con los eventos.
     */
    public function esdeveniments()
    {
        return $this->hasMany(Esdeveniment::class);
    }

    /**
     * Obtiene todas las categorías con el recuento de eventos asociados.
     */
    public function getCategoriesWithEventCount()
    {
        return $this->all()->map(function ($category) {
            $category->eventCount = Esdeveniment::join(
                DB::raw('(SELECT esdeveniments_id, MIN(data) as min_data FROM sessios GROUP BY esdeveniments_id) as min_dates'),
                function ($join) use ($category) {
                    $join->on('esdeveniments.id', '=', 'min_dates.esdeveniments_id')
                        ->where('esdeveniments.categoria_id', $category->id);
                }
            )
                ->leftJoin('sessios', function ($join) {
                    $join->on('esdeveniments.id', '=', 'sessios.esdeveniments_id')
                        ->on('sessios.data', '=', 'min_dates.min_data');
                })
                ->select('esdeveniments.*', 'min_dates.min_data as min_data')
                ->where('esdeveniments.ocult', false) // Filtrar eventos no ocultos
                ->where('min_dates.min_data', '>', now())

                ->count();

            return $category;
        });
    }

    /**
     * Obtiene las categorías con al menos dos eventos asociados.
     */
    public static function getCategoriesWith3()
    {
        return DB::table('categories')
            ->join('esdeveniments', 'categories.id', '=', 'esdeveniments.categoria_id')
            ->select('categories.*', DB::raw('COUNT(esdeveniments.id) as event_count'))
            ->groupBy('categories.id')
            ->havingRaw('COUNT(esdeveniments.id) > 1')
            ->get();
    }

    /**
     * Obtiene eventos filtrados por búsqueda y categoría.
     */
    public static function getFilteredEvents($cerca, $categoryId)
    {
        $query = Esdeveniment::with(['recinte'])
            ->join(
                DB::raw('(SELECT esdeveniments_id, MIN(data) as min_data FROM sessios GROUP BY esdeveniments_id) as min_dates'),
                function ($join) {
                    $join->on('esdeveniments.id', '=', 'min_dates.esdeveniments_id');
                }
            )
            ->leftJoin('sessios', function ($join) {
                $join->on('esdeveniments.id', '=', 'sessios.esdeveniments_id')
                    ->on('sessios.data', '=', 'min_dates.min_data');
            })
            ->select('esdeveniments.*', 'min_dates.min_data as min_data')
            ->where('esdeveniments.ocult', false)
            ->where('min_dates.min_data', '>', now())
            ->orderBy('min_data', 'asc');

        if ($categoryId !== null) {
            $query->where('categoria_id', $categoryId);

            if ($cerca) {
                $query->where(function ($query) use ($cerca, $categoryId) {
                    $query->whereRaw("LOWER(unaccent(nom)) LIKE LOWER(unaccent(?))", ["%" . $cerca . "%"])
                        ->where('categoria_id', $categoryId);
                })
                    ->orWhereHas('recinte', function ($query) use ($cerca, $categoryId) {
                        $query->whereRaw("LOWER(unaccent(lloc)) LIKE LOWER(unaccent(?))", ["%" . $cerca . "%"])
                            ->where('categoria_id', $categoryId);
                    });
            }
        } else {
            if ($cerca) {
                $query->where(function ($query) use ($cerca) {
                    $query->whereRaw("LOWER(unaccent(nom)) LIKE LOWER(unaccent(?))", ["%" . $cerca . "%"])
                        ->orWhereHas('recinte', function ($query) use ($cerca) {
                            $query->whereRaw("LOWER(unaccent(lloc)) LIKE LOWER(unaccent(?))", ["%" . $cerca . "%"]);
                        });
                });
            }
        }

        return $query->paginate(config('app.items_per_page', 6))->appends(request()->query());
    }
};
