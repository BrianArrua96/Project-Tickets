<?php

namespace App\Http\Controllers;

use App\Models\Opinion;
use App\Models\Categoria;
use App\Models\Esdeveniment;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Config;

/**
 * Controlador para gestionar las opiniones de los eventos.
 */
class OpinionController extends Controller
{
    /**
     * Muestra la página para crear una nueva opinión o redirige a la página de inicio si no se proporciona un ID de evento.
     *
     * @param  \Illuminate\Http\Request  $request La solicitud HTTP.
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse La vista para crear una nueva opinión o la página de inicio.
     */
    public function newOpinionPage(Request $request)
    {
        // Obtener el ID del evento desde la solicitud
        $id = $request->input('event-id');
        if (!isset($id)) {
            // Redirigir a la página de inicio si no se proporciona un ID de evento
            $pag = Config::get('app.items_per_page', 100);
            $categoryId = ''; // Establece un valor predeterminado

            $esdeveniments = Esdeveniment::with(['recinte'])
                // Ordenar por fecha descendente
                ->paginate($pag);

            $events = Esdeveniment::getAllEvents($pag);

            $categories = Categoria::all();
            $categoriesWithEventCount = (new Categoria())->getCategoriesWithEventCount();

            $categoriesWith3 = Categoria::getCategoriesWith3();
            return view('home', compact('esdeveniments', 'categories', 'categoryId', 'categoriesWithEventCount', 'events', 'categoriesWith3'));
        } else {

            // Redirigir a la vista de crear opinión y pasar el $eventoId si es necesario
            return view('crearOpinion', compact('id'));
        }
    }

    public function store(Request $request)
    {
        $esdevenimentId = $request->input('event-id');
        // Mapear emojis a valores específicos
        $emojiMapping = [
            '😠' => 1,
            '😞' => 2,
            '😐' => 3,
            '😊' => 4,
            '😃' => 5,
        ];

        // Obtener el valor de emocio según el emoji seleccionado
        $emocio = $emojiMapping[$request->input('valoracion')];

        // Crear una nueva instancia de Opinion
        $opinio = new Opinion([
            'nom' => $request->input('nombre'),
            'emocio' => $emocio,
            'puntuacio' => $request->input('puntuacion'),
            'titol' => $request->input('titulo'),
            'comentari' => $request->input('comentario'),
            'esdeveniment_id' => $esdevenimentId,
        ]);

        // Guardar la opinión en la base de datos
        $opinio->save();

        // Redirigir a la página del evento correspondiente con un mensaje de éxito
        return redirect()->route('mostrar-esdeveniment', [$esdevenimentId])->with('success', 'Opinion creada correctamente');
    }
}
