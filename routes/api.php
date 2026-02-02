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
    $owner = Owners::find($id);

    if (!$owner) {
        return response()->json([
            'mensaje' => 'No se ha encontrado ningún dueño con el identificador ' . $id
        ], 404);
    } else {
        return new OwnersResource($owner);
    }
});

//Ruta para insertar un dueño en la base de datos

Route::post('/owner', function (Request $request) {
    $owner = Owners::create([
        'name' => $request->input('nombre'),
        'surname' => $request->input('apellido'),
    ]);

    if ($owner) {
        return response()->json([
            'mensaje' => 'Dueño añadido correctamente',
            'datos' => new OwnersResource($owner)
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
        'datos_actualizados' => new OwnersResource($owner),
    ]);
});

//Ruta que elimina un dueño según el identificador pasado por URL, se eliminarán todos los animales que tengan el identificador en el campo 'owner_id'
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

//Ruta para ver todos los dueños registrados en la base de datos
Route::get('/owners', function () {
    return OwnersResource::collection(Owners::all());
});

//Ruta para ver los datos de un animal, pasando su identificador por URL

Route::get('/animal/{id}', function ($id) {
    $animal = Animals::find($id);

    if (!$animal) {
        return response()->json([
            'mensaje' => 'No se ha encontrado ningún animal con el identificador ' . $id
        ], 404);
    } else {
        return new AnimalResource($animal);
    }
});

//Ruta para crear un animal, se verificará que el owner_id existe en la tabla owners y que el tipo de animal es válido

Route::post('/animal/', function (Request $request) {
    $owner_id = $request->input('owner_id');
    $owner = Owners::find($owner_id);
    $validTypes = ['perro', 'gato', 'conejo', 'hámster'];
    $tipo = $request->input('tipo');

    if (!$owner) {
        return response()->json([
            'mensaje' => 'No se ha podido registrar el animal, no se ha encontrado ningún dueño con el identificador ' . $owner_id
        ], 403);
    } else {

        //Comprueba que el tipo de animal esté disponible y crea el animal
        if (in_array($tipo, $validTypes)) {
            $animal = Animals::create([
                'nombre' => $request->input('nombre'),
                'tipo' => $tipo,
                'peso' => $request->input('peso'),
                'enfermedad' => $request->input('enfermedad'),
                'comentarios' => $request->input('comentarios'),
                'owner_id' => $owner_id,
            ]);
        } else {

            //Devuelve un mensaje de error si el tipo de animal no es válido
            return response()->json([
                'mensaje' => 'El tipo de animal seleccionado no está disponible'
            ], 400);
        }

        //Si se ha creado el animal, devuelve un mensaje de éxito junto con los datos del animal creado
        if ($animal) {
            return response()->json([
                'mensaje' => 'Animal añadido correctamente, el identificador del dueño es ' . $owner_id,
                'datos' => new AnimalResource($animal)
            ], 201);
        }
    }
});

//Ruta que elimina un animal según su identificador
Route::delete('/animal/{id}', function ($id) {
    $animal = Animals::find($id);

    if (!$animal) {
        return response()->json([
            'mensaje' => 'No se ha encontrado ningún animal con el identificador ' . $id
        ], 404);
    }

    $animal->delete();

    return response()->json([
        'mensaje' => 'Se ha eliminado correctamente el animal con identificador ' . $id
    ]);
});

//Ruta para actualiza los datos de un animal (menos dueño y su propio identificador)

Route::put('/animal/{id}', function (Request $request, $id) {
    $animal = Animals::find($id);
    $tipo = $request->input('tipo');
    $validTypes = ['perro', 'gato', 'conejo', 'hámster'];

    if (!$animal) {
        return response()->json([
            'mensaje' => 'No se ha encontrado ningún animal con el identificador ' . $id
        ], 404);
    }


    if (in_array($tipo, $validTypes)) {
        $animal->update([
            'nombre' => $request->input('nombre'),
            'tipo' => $request->input('tipo'),
            'peso' => $request->input('peso'),
            'enfermedad' => $request->input('enfermedad'),
            'comentarios' => $request->input('comentarios'),
        ]);

        return response()->json([
            'mensaje' => 'Animal con el identificador ' . $id . ' actualizado correctamente',
            'datos_actualizados' => new AnimalResource($animal)
        ], 200);
    } else {
        return response()->json([
            'mensaje' => 'El tipo de animal seleccionado no está disponible'
        ], 400);
    }
});

//Ruta para ver todos los animales registrados en la base de datos
Route::get('/animals', function () {
    $animals = Animals::all();

    if ($animals->isEmpty()) {
        return response()->json([
            'mensaje' => 'No hay ningún animal registrado'
        ], 404);
    } else {
        return AnimalResource::collection(Animals::all());
    }

});
