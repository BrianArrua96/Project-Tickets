<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Sessio;
use App\Models\Entrada;
use App\Models\Esdeveniment;
use App\Models\Opinion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Symfony\Component\Console\Input\Input;

/**
 * Controlador para editar los detalles de un evento.
 */
class EditarEsdevenimentController extends Controller
{
  /**
   * Muestra la vista para editar un evento.
   *
   * @param  int  $id
   * @return \Illuminate\Contracts\View\View
   */
  public function editar($id)
  {
    // Obtiene el evento con el ID proporcionado
    $esdeveniment = Esdeveniment::findOrFail($id);

    // Obtiene las fechas asociadas al evento
    $fechas = Esdeveniment::join('sessios', 'sessios.esdeveniments_id', '=', 'esdeveniments.id')
      ->select('esdeveniments.*', 'sessios.*')
      ->where('esdeveniments.id', '=', $id)
      ->get();


    // Obtener opiniones asociadas al evento
    $opiniones = Opinion::where('esdeveniment_id', $id)->get();

    // Convierte los códigos de emoción en emojis y puntuaciones en estrellas
    foreach ($opiniones as $opinion) {
      $opinion->emocio = $this->getEmoji($opinion->emocio);
      $opinion->estrellas = $this->convertirPuntuacionAEstrellas($opinion->puntuacio);
    }

    // Retorna la vista para editar el evento
    return view('editarEsdeveniment', compact('esdeveniment', 'fechas', 'opiniones'));
  }

  /**
   * Convierte el código de emoción en un emoji.
   *
   * @param  string  $emocio
   * @return string
   */
  private function getEmoji($emocio)
  {
    // Define los emojis correspondientes a cada código de emoción
    $emojis = [
      '1' => '😠',
      '2' => '😞',
      '3' => '😐',
      '4' => '😊',
      '5' => '😃',
    ];

    // Retorna el emoji correspondiente al código de emoción proporcionado
    return $emojis[$emocio] ?? '';
  }

  /**
   * Convierte la puntuación en estrellas visuales.
   *
   * @param  int  $puntuacion
   * @return string
   */
  private function convertirPuntuacionAEstrellas($puntuacion)
  {
    // Inicializa la cadena de estrellas
    $estrellas = '';

    // Genera las estrellas según la puntuación
    for ($i = 1; $i <= 5; $i++) {
      $clase = ($i <= $puntuacion) ? 'star selected' : 'star';
      $estrellas .= "<span class=\"$clase\" data-rating=\"$i\">&#9733;</span>";
    }

    // Retorna las estrellas generadas
    return $estrellas;
  }

  /**
   * Muestra la página para agregar una nueva sesión.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Contracts\View\View
   */
  public function newSessionPage(Request $request)
  {
    // Obtiene el ID del evento
    $id = $request->input('event-id');

    // Retorna la vista para agregar una nueva sesión
    return view('añadirSesion', compact('id'));
  }

  /**
   * Agrega una nueva sesión al evento.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\RedirectResponse
   */
  public function newSesion(Request $request)
  {
    try {
      // Obtiene el ID del evento
      $esdevenimentId = $request->input('event-id');

      // Crear la sesión
      $sessio = new Sessio([
        'data' => $request->input('data_hora'),
        'tancament' => $request->input('dataHoraPersonalitzada'),
        'aforament' => $request->input('aforament_maxim'),
        'esdeveniments_id' => $esdevenimentId,
        'estado' => true,
      ]);
      $sessio->save();

      // Si se crea correctamente, obtiene el ID de la sesión
      if ($sessio) {
        $sessioId = $sessio->id;
      }

      // Obtener datos de las entradas
      $noms = $request->input('entrades-nom');
      $preus = $request->input('entrades-preu');
      $quantitats = $request->input('entrades-quantitat');
      $nominal = $request->input('entradaNominalCheck');

      // Procesar los datos según sea necesario
      for ($i = 0; $i < count($noms); $i++) {
        $entrada = new Entrada([
          'nom' => $noms[$i],
          'preu' => $preus[$i],
          'quantitat' => $quantitats[$i],
          'nominal' => $nominal[$i],
          'sessios_id' => $sessioId,
        ]);

        $entrada->save();
      }
      // Registra un mensaje de información
      Log::info('Creada nueva sesion para el evento ' . $esdevenimentId);
    } catch (Exception $e) {
      // Registra un mensaje de error si ocurre una excepción
      Log::error('Error al intentar crear la nueva sesion para el evento ' . $esdevenimentId . '. Mensaje de error: ' . $e->getMessage());
    }

    // Redirige a la página de edición del evento
    return redirect()->route('editar-esdeveniment', [$esdevenimentId]);
  }

  /**
   * Muestra la página para modificar una sesión.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Contracts\View\View
   */
  public function updateSesionPage(Request $request)
  {
    // Obtener el ID del evento y de la sesión
    $id = $request->input('eventoId');
    $sessioId = $request->input('fechaId');

    // Obtener información de la sesión
    $sessiones = Sessio::where("sessios.id", "=", $sessioId)->first();

    // Obtener las entradas asociadas a la sesión
    $entradas = Entrada::where("entradas.sessios_id", "=", $sessioId)->get();

    // Retornar la vista para editar la sesión con los datos obtenidos
    return view('editarSesion', compact('sessioId', 'id', 'sessiones', 'entradas'));
  }

  /**
   * Modifica una sesión del evento.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\RedirectResponse
   */
  public function updateSesion(Request $request)
  {
    try {
      // Obtener los IDs del evento y de la sesión
      $esdevenimentId = $request->input('event-id');
      $sessioId = $request->input('fecha-id');

      // Actualizar los detalles de la sesión
      Sessio::where('sessios.id', '=', $sessioId)
        ->update([
          'data' => $request->input('data_hora'),
          'tancament' => $request->input('dataHoraPersonalitzada'),
          'aforament' => $request->input('aforament_maxim'),
        ]);
      // Obtener las entradas asociadas a la sesión
      $entradas = Entrada::where("entradas.sessios_id", "=", $sessioId)->get();

      // Obtener datos de las entradas del formulario
      $noms = $request->input('entrades-nom');
      $preus = $request->input('entrades-preu');
      $quantitats = $request->input('entrades-quantitat');
      $nominal = $request->input('entradaNominalCheck');

      // Procesar los datos según sea necesario
      if (count($noms) == count($entradas)) {
        for ($i = 0; $i < count($noms); $i++) {
          Entrada::where('entradas.id', '=', $entradas[$i]->id)
            ->update([
              'nom' => $noms[$i],
              'preu' => $preus[$i],
              'quantitat' => $quantitats[$i],
              'nominal' => $nominal[$i],
              'sessios_id' => $sessioId,
            ]);
        }
      } else if (count($noms) > count($entradas)) {
        for ($i = 0; $i < count($entradas); $i++) {
          Entrada::where('entradas.id', '=', $entradas[$i]->id)
            ->update([
              'nom' => $noms[$i],
              'preu' => $preus[$i],
              'quantitat' => $quantitats[$i],
              'nominal' => $nominal[$i],
              'sessios_id' => $sessioId,
            ]);
        }
        for ($i = count($entradas); $i < count($noms); $i++) {
          $entrada = new Entrada([
            'nom' => $noms[$i],
            'preu' => $preus[$i],
            'quantitat' => $quantitats[$i],
            'nominal' => $nominal[$i],
            'sessios_id' => $sessioId,
          ]);

          $entrada->save();
        }
      } else if (count($noms) < count($entradas)) {
        for ($i = 0; $i < count($noms); $i++) {
          Entrada::where('entradas.id', '=', $entradas[$i]->id)
            ->update([
              'nom' => $noms[$i],
              'preu' => $preus[$i],
              'quantitat' => $quantitats[$i],
              'nominal' => $nominal[$i],
              'sessios_id' => $sessioId,
            ]);
        }
        for ($i = count($noms); $i < count($entradas); $i++) {
          Entrada::where('entradas.id', '=', $entradas[$i]->id)
            ->delete();
        }
      }
      Log::info('Guardada sesion: ' . $sessioId . ' del evento ' . $esdevenimentId);
    } catch (Exception $e) {
      Log::error('Error al intentar guardar la sesion: ' . $sessioId . ' para el evento ' . $esdevenimentId . '. Mensaje de error: ' . $e->getMessage());
    }

    return redirect()->route('editar-esdeveniment', [$esdevenimentId]);
  }
  /**
   * Cierra una sesión del evento.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Contracts\View\View
   */
  public function cerrarSesion(Request $request)
  {
    // Obtener el evento
    $esdeveniment = Esdeveniment::findOrFail($request->input("eventoId"));

    // Actualizar el estado de la sesión a cerrado
    Sessio::where('sessios.id', '=', $request->input("fechaId"))
      ->update([
        'estado' => false,
      ]);

    // Obtener las fechas asociadas al evento
    $fechas = Esdeveniment::join('sessios', 'sessios.esdeveniments_id', '=', 'esdeveniments.id')
      ->select('esdeveniments.*', 'sessios.*')
      ->where('esdeveniments.id', '=', $request->input("fechaId"))
      ->get();

    // Obtener opiniones asociadas al evento
    $opiniones = Opinion::where('esdeveniment_id', $request->input("eventoId"))->get();

    // Actualizar las emociones y estrellas de las opiniones
    foreach ($opiniones as $opinion) {
      $opinion->emocio = $this->getEmoji($opinion->emocio);
      $opinion->estrellas = $this->convertirPuntuacionAEstrellas($opinion->puntuacio);
    }

    // Establecer el estado como cerrado
    $estado = false;

    // Retornar la vista con los datos actualizados
    return view('editarEsdeveniment', compact('esdeveniment', 'fechas', 'opiniones', 'estado'));
  }

  /**
   * Abre una sesión del evento.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Contracts\View\View
   */
  public function abrirSesion(Request $request)
  {
    // Obtener el evento
    $esdeveniment = Esdeveniment::findOrFail($request->input("eventoId"));

    // Actualizar el estado de la sesión a abierto
    Sessio::where('sessios.id', '=', $request->input("fechaId"))
      ->update([
        'estado' => true,
      ]);

    // Obtener las fechas asociadas al evento
    $fechas = Esdeveniment::join('sessios', 'sessios.esdeveniments_id', '=', 'esdeveniments.id')
      ->select('esdeveniments.*', 'sessios.*')
      ->where('esdeveniments.id', '=', $request->input("fechaId"))
      ->get();

    // Obtener opiniones asociadas al evento
    $opiniones = Opinion::where('esdeveniment_id', $request->input("eventoId"))->get();

    // Actualizar las emociones y estrellas de las opiniones
    foreach ($opiniones as $opinion) {
      $opinion->emocio = $this->getEmoji($opinion->emocio);
      $opinion->estrellas = $this->convertirPuntuacionAEstrellas($opinion->puntuacio);
    }

    // Establecer el estado como abierto
    $estado = true;

    // Retornar la vista con los datos actualizados
    return view('editarEsdeveniment', compact('esdeveniment', 'fechas', 'opiniones', 'estado'));
  }
}
