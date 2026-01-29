<?php

use App\Http\Resources\OwnersResource;
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
