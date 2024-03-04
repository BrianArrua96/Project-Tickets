<?php

namespace App\Http\Controllers\Api;

use App\Models\Image;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


// Controlador para gestionar las imágenes
class ServeiImatgeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() //GET
    {
        // Obtiene todas las imágenes de la base de datos y las devuelve como JSON
        $image = Image::on('imageDB')->get();
        return response()->json($image);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) //POST
    {
        //Recibe la información de la imagen
        $imatge = $request->imatge;
        $nomOriginal = $imatge['name'];
        $pathImage = $imatge['path'];
        $nomImatge = time() . '_' . $nomOriginal;

        // Procesamiento de la imagen para distintos tamaños
        list($width, $height) = getimagesize($pathImage);
        $ratio = $width / $height;
        $newWidthMovil = 200;
        $newHeightMovil = 200 / $ratio;
        $imageMovil = imagecreatetruecolor($newWidthMovil, $newHeightMovil);
        $source = imagecreatefromjpeg($pathImage);
        imagecopyresampled($imageMovil, $source, 0, 0, 0, 0, $newWidthMovil, $newHeightMovil, $width, $height);
        imagejpeg($imageMovil, storage_path('app/public/images/' . $nomImatge . '_movil'));

        // Almacenamiento de las imágenes procesadas
        $newWidthTablet = 300;
        $newHeightTablet = 300 / $ratio;
        $imageTablet = imagecreatetruecolor($newWidthTablet, $newHeightTablet);
        imagecopyresampled($imageTablet, $source, 0, 0, 0, 0, $newWidthTablet, $newHeightTablet, $width, $height);
        imagejpeg($imageTablet, storage_path('app/public/images/' . $nomImatge . '_tablet'));

        // Guarda en la base de datos las rutas hacia las imágenes
        $newWidthOrdenador = 400;
        $newHeightOrdenador = 400 / $ratio;
        $imageOrdenador = imagecreatetruecolor($newWidthOrdenador, $newHeightOrdenador);
        imagecopyresampled($imageOrdenador, $source, 0, 0, 0, 0, $newWidthOrdenador, $newHeightOrdenador, $width, $height);
        imagejpeg($imageOrdenador, storage_path('app/public/images/' . $nomImatge . '_ordenador'));

        //Guarda en la bd las rutas hacia las imagenes
        $imagen = new Image([
            'imageMovil' => ('storage/' . $nomImatge . '_movil'),
            'imageTablet' => ('storage/' . $nomImatge . '_tablet'),
            'imageOrdenador' => ('storage/' . $nomImatge . '_ordenador'),
        ]);
        $imagen->setConnection('imageDB');
        $imagen->save();
        return response()->json('Añadido correctamente: ' . $imagen);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id) //GET /{id}
    {
        // Muestra la imagen específica según el ID
        $imagen = Image::on('imageDB')->where('id', $id)->first();
        return response()->json($imagen);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id) //PUT
    {
        // Actualiza la imagen específica según el ID con la información proporcionada
        $imagen = Image::on('imageDB')->where('id', $id)->update([
            'urlUnica' => $request->urlUnica,
            'imageMovil' => $request->imageMovil,
            'imageTablet' => $request->imageTablet,
            'imageOrdenador' => $request->imageOrdenador,
        ]);
        return response()->json('Actualizado correctamente: ' . $imagen);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id) //DELETE
    {
        // Elimina la imagen específica según el ID
        $imagen = Image::on('imageDB')->where('id', $id)->delete();
        return response()->json('Eliminado correctamente: ' . $imagen);
    }
}
