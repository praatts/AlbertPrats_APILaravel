<?php

use App\Http\Resources\OwnersResource;
use App\Models\Animals;
use App\Http\Resources\AnimalResource;
use App\Models\Owners;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

//URL: http://127.0.0.1:8000/api/*

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

//Devuelve los datos de un único dueño, se pasa su identificador por parámetro de la URL
Route::get('/owner/{id}', function ($id) {
    return new OwnersResource(Owners::findOrFail($id));
});

//Ruta para insertar un "dueño" en la tabla 'owners' en la base de datos

Route::post('/owner', function (Request $request) {
    $owner = Owners::create([
        'name' => $request->input('nombre'),
        'surname' => $request->input('apellido'),
    ]);

    if ($owner) {
        return response()->json([
            'mensaje' => 'Dueño añadido correctamente',
        ], 201);
    }
});

//Ruta para actualizar un dueño según el identificador pasado por URL.

Route::put('/owner/{id}', function (Request $request, $id) {
    $owner = Owners::find($id);

    if (!$owner) {
        return response()->json([
            'mensaje' => 'No se ha encontrado ningún Owner con el identificador ' . $id
        ], 404);
    }

    $owner->update([
        'name' => $request->input('nombre'),
        'surname' => $request->input('apellido'),
    ]);

    return response()->json([
        'mensaje' => 'Owner con el identificador ' . $id . ' actualizado correctamente',
    ]);
});

//Ruta que elimina un dueño según el identificador pasado por URL
Route::delete('/owner/{id}', function ($id) {
    $owner = Owners::find($id);

    if (!$owner) {
        return response()->json([
            'mensaje' => 'No se ha encontrado ningún dueño con el identificador ' . $id
        ], 404);
    }

    $owner->delete();

    return response()->json([
        'mensaje' => 'Se ha eliminado correctamente el Owner con identificador ' . $id
    ]);
});

//Ruta para ver los datos de un animal, pasando su identificador por URL

Route::get('/animal/{id}', function ($id) {
    return new AnimalResource(Animals::findOrFail($id));
});

//Ruta para crear un animal, la id del dueño se pasa por parámetro, se verifica primero que el dueño exista en la base de datos

Route::post('/animal/{owner_id}', function (Request $request, $owner_id) {
    $owner = Owners::find($owner_id);
    $validTypes = ['perro', 'gato', 'conejo', 'hámster'];
    $tipo = $request->input('tipo');

    if (!$owner) {
        return response()->json([
            'mensaje' => 'No se ha podido registrar el animal, no se ha encontrado ningún dueño con el identificador ' . $owner_id
        ], 403);
    } else {

        //Comprueba que el tipo de animal esté disponible
        if (in_array($tipo, $validTypes)) {
            $animal = Animals::create(attributes: [
                'nombre' => $request->input('nombre'),
                'tipo' => $tipo,
                'peso' => $request->input('peso'),
                'enfermedad' => $request->input('enfermedad'),
                'comentarios' => $request->input('comentarios'),
                'owner_id' => $owner_id,
            ]);
        } else {
            return response()->json([
                'mensaje' => 'El tipo de animal seleccionado no está disponible'
            ], 400);
        }

        if ($animal) {
            return response()->json([
                'mensaje' => 'Animal añadido correctamente',
            ], 201);
        }
    }

});

Route::delete('/animal/{id}', function() {

});


