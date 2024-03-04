<?php

namespace App\Http\Controllers;

use App\Models\Sessio;
use App\Models\Categoria;
use App\Models\Esdeveniment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Config;

class HomeController extends Controller
{
  /**
   * Muestra la página de inicio con los eventos disponibles.
   *
   * @return \Illuminate\Contracts\View\View
   */
  public function index()
  {
    // Configuración para la paginación
    $pag = Config::get('app.items_per_page', 100);
    $categoryId = ''; // Establece un valor predeterminado

    // Obtener eventos paginados ordenados por fecha
    $esdeveniments = Esdeveniment::with(['recinte'])
      ->paginate($pag);

    // Obtener todos los eventos para la sección de eventos destacados
    $events = Esdeveniment::getAllEvents($pag);

    // Obtener todas las categorías
    $categories = Categoria::all();

    // Obtener la cantidad de eventos por categoría
    $categoriesWithEventCount = (new Categoria())->getCategoriesWithEventCount();

    // Obtener categorías con al menos 3 eventos asociados
    $categoriesWith3 = Categoria::getCategoriesWith3();

    // Registro de información
    Log::info('Los eventos han sido recuperados con éxito');

    // Renderizar la vista de inicio con los datos necesarios
    return view('home', compact('esdeveniments', 'categories', 'categoryId', 'categoriesWithEventCount', 'events', 'categoriesWith3'));
  }

  /**
   * Muestra la página de inicio con un mensaje de ticket.
   *
   * @param  string  $compra
   * @return \Illuminate\Contracts\View\View
   */
  public function msgTicket($compra)
  {
    // Configuración para la paginación
    $pag = Config::get('app.items_per_page', 100);
    $categoryId = ''; // Establece un valor predeterminado

    // Obtener eventos paginados ordenados por fecha
    $esdeveniments = Esdeveniment::with(['recinte'])
      ->paginate($pag);

    // Obtener todos los eventos para la sección de eventos destacados
    $events = Esdeveniment::getAllEvents($pag);

    // Obtener todas las categorías
    $categories = Categoria::all();

    // Obtener la cantidad de eventos por categoría
    $categoriesWithEventCount = (new Categoria())->getCategoriesWithEventCount();

    // Obtener categorías con al menos 3 eventos asociados
    $categoriesWith3 = Categoria::getCategoriesWith3();

    // Renderizar la vista de inicio con los datos necesarios y el mensaje de ticket
    return view('home', compact('esdeveniments', 'categories', 'categoryId', 'categoriesWithEventCount', 'events', 'categoriesWith3', 'compra'));
  }

  /**
   * Realiza una búsqueda de eventos según los parámetros proporcionados.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Contracts\View\View
   */
  public function cerca(Request $request)
  {
    // Obtener el término de búsqueda y la categoría seleccionada
    $cerca = $request->input('q');
    $categoryId = $request->input('category');

    // Realizar la búsqueda de eventos filtrados por término de búsqueda y categoría
    $esdeveniments = Categoria::getFilteredEvents($cerca, $categoryId);

    // Obtener todas las categorías
    $categories = Categoria::all();

    // Obtener la cantidad de eventos por categoría
    $categoriesWithEventCount = (new Categoria())->getCategoriesWithEventCount();

    // Obtener todas las sesiones
    $sessio = Sessio::all();

    // Obtener eventos ordenados por la categoría seleccionada
    $eventsOrdenats = Esdeveniment::getOrderedEvents($categoryId);

    // Renderizar la vista de resultados con los datos necesarios
    return view('resultados', compact('esdeveniments', 'categories', 'categoryId', 'categoriesWithEventCount', 'sessio', 'eventsOrdenats'));
  }
}
