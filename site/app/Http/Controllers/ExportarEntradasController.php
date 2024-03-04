<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sessio;
use App\Models\Compra;
use App\Models\CompraEntrada;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ExportarEntradasController extends Controller
{
    /**
     * Exporta las entradas de una sesión específica a un archivo CSV.
     *
     * @param  int  $sessioId
     * @return \Symfony\Component\HttpFoundation\StreamedResponse
     */
    public function exportarCSV($sessioId)
    {
        // Obtener la sesión correspondiente
        $sessio = Sessio::findOrFail($sessioId);

        // Obtener las compras asociadas a la sesión con las entradas
        $compras = Compra::whereHas('sessio', function ($query) use ($sessioId) {
            $query->where('id', $sessioId);
        })->with('compraEntrada.entrada')->get();

        // Configurar los encabezados del archivo CSV
        $headers = array(
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=entradas_sessio_" . $sessioId . ".csv",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        );

        // Definir la función de devolución de llamada para generar el contenido del archivo CSV
        $callback = function () use ($compras) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['Nom comprador', 'Codi d’entrada', 'Tipus d’entrada']);

            foreach ($compras as $compra) {
                foreach ($compra->compraEntrada as $compraEntrada) {
                    foreach ($compraEntrada->entrada as $entrada) {
                        fputcsv($file, [$compraEntrada->nomComprador, $compraEntrada->numeroIdentificador, $compraEntrada->entrada->nom]);
                    }
                }
            }

            fclose($file);
        };

        // Devolver la respuesta de transmisión con los encabezados y la función de devolución de llamada configurados
        return response()->stream($callback, 200, $headers);
    }
}
