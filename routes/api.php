<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\EvidenciasController;
use App\Http\Controllers\API\TareaController;
use App\Http\Controllers\API\EvaluacionController;
use App\Http\Controllers\API\EvaluacionesEvidenciasController;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('v1')->group(function () {


    Route::prefix('criterios-evaluacion/{criterio_evaluacion_id}')->group(function () {
        Route::get('tareas', [TareaController::class, 'indexByCriterio']);
        Route::post('tareas', [TareaController::class, 'storeByCriterio']);
        Route::get('tareas/{id}', [TareaController::class, 'showByCriterio']);
    });


    Route::post('tareas', [TareaController::class, 'store']);
    Route::put('tareas/{id}', [TareaController::class, 'update']);
    Route::delete('tareas/{id}', [TareaController::class, 'destroy']);


    Route::prefix('tareas/{tarea_id}')->group(function () {
        Route::apiResource('evidencias', EvidenciasController::class);
    });


    Route::prefix('evidencias/{evidencia_id}')->group(function () {
        Route::apiResource('evaluaciones-evidencias', EvaluacionesEvidenciasController::class);
    });
});
