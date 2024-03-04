<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use App\Models\Esdeveniment;
use App\Models\Opinion;
use Illuminate\Http\Request;
use Geocoder\Laravel\Facades\Geocoder;


class EsdevenimentController extends Controller
{

  /**
   * Muestra los detalles de un evento.
   *
   * @param  int  $id
   * @return \Illuminate\View\View
   */
  public function show($id)
  {
    // Obtener el evento por su ID
    $event = Esdeveniment::findOrFail($id);

    // Obtener el primer evento local asociado al evento
    $esdeveniment = Esdeveniment::getFirstEventLocal($id);


    // Obtener las sesiones del evento  
    $fechas = Esdeveniment::getSessiosEvent($id);

    // Obtener las entradas del evento
    $entradas = Esdeveniment::getEntradesEvent($id);

    $preuTotal = 0; // Establecer el precio total inicial
    $fechaSola = false; // Establecer la bandera de fecha única como falsa por defecto

    // Obtener opiniones asociadas al evento
    $opiniones = Opinion::where('esdeveniment_id', $id)->get();

    // Recorrer las opiniones para procesar emojis y estrellas
    foreach ($opiniones as $opinion) {
      $opinion->emocio = $this->getEmoji($opinion->emocio);
      $opinion->estrellas = $this->convertirPuntuacionAEstrellas($opinion->puntuacio);
    }

    // Retornar la vista con los datos obtenidos
    return view('esdeveniment', compact('esdeveniment', 'fechas', 'entradas', 'preuTotal', 'fechaSola', 'opiniones', 'event'));
  }

  /**
   * Obtiene el emoji correspondiente a una emoción.
   *
   * @param  string  $emocio
   * @return string
   */
  private function getEmoji($emocio)
  {
    // Definir los emojis correspondientes a las emociones
    $emojis = [
      '1' => '😠',
      '2' => '😞',
      '3' => '😐',
      '4' => '😊',
      '5' => '😃',
    ];

    // Retornar el emoji correspondiente a la emoción, o una cadena vacía si no hay correspondencia
    return $emojis[$emocio] ?? '';
  }

  /**
   * Convierte una puntuación en estrellas representadas por HTML.
   *
   * @param  int  $puntuacion
   * @return string
   */
  private function convertirPuntuacionAEstrellas($puntuacion)
  {
    // Inicializar la cadena de estrellas
    $estrellas = '';

    // Recorrer desde 1 hasta 5 para construir las estrellas según la puntuación
    for ($i = 1; $i <= 5; $i++) {
      // Establecer la clase CSS de la estrella según si la puntuación es igual o mayor a la iteración actual
      $clase = ($i <= $puntuacion) ? 'star selected' : 'star';

      // Construir la etiqueta span con la clase y el código HTML de la estrella
      $estrellas .= "<span class=\"$clase\" data-rating=\"$i\">&#9733;</span>";
    }

    // Retornar la cadena de estrellas
    return $estrellas;
  }

  /**
   * Obtiene la URL y muestra los detalles de la ubicación de un evento.
   *
   * @param  int  $id
   * @return \Illuminate\View\View
   */
  public function local($id)
  {
    // Obtener los detalles del recinto asociado al evento
    $esdeveniment = Esdeveniment::join('recintes', 'recintes.id', '=', 'esdeveniments.recinte_id')
      ->select('recintes.*')
      ->where('esdeveniments.id', '=', $id)
      ->first();

    // Construir la dirección para la búsqueda
    $provincia = str_replace(' ', '+', $esdeveniment->provincia);
    $lloc = str_replace(' ', '+', $esdeveniment->lloc);
    $direccion = $provincia . '+' . $lloc;

    // Realizar la búsqueda de geolocalización utilizando el servicio de Nominatim
    $client = new Client();
    $response = $client->get('https://nominatim.openstreetmap.org/search?q=' . $direccion . '&format=json', [
      'verify' => false,
    ]);

    // Decodificar la respuesta JSON
    $data = json_decode($response->getBody(), true);

    // Obtener las coordenadas de latitud y longitud si están disponibles
    if (!empty($data)) {
      $lat = $data[0]['lat'] ?? null;
      $long = $data[0]['lon'] ?? null;
    }

    // Retornar la vista con los detalles de la ubicación
    return view('detallesLocal', compact('esdeveniment', 'lat', 'long'));
  }
}
