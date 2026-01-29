<?php

use App\Http\Resources\OwnersResource;
use App\Models\Owners;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

//Devuelve los datos de un único dueño, se pasa su identificador por id
Route::get('/owner/{id}', function (string $id) {
    return Ownersreturn User::findOrFail($id)->toResource();

::findOrFail($id)->toResource();
});
