<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\TareaResource;
use App\Models\Tarea;
use Illuminate\Http\Request;

class TareaController extends Controller
{

    public function index(Request $request)
    {
        return TareaResource::collection(
            Tarea::orderBy($request->_sort ?? 'id', $request->_order ?? 'asc')
                ->paginate($request->perPage)
        );
    }

    public function store(Request $request)
    {
        $tareaData = json_decode($request->getContent(), true);

        $tarea = Tarea::create($tareaData);

        return new TareaResource($tarea);
    }

    public function show(Tarea $tarea)
    {
        return new TareaResource($tarea);
    }

    public function update(Request $request, Tarea $tarea)
    {
        $tareaData = json_decode($request->getContent(), true);
        $tarea->update($tareaData);

        return new TareaResource($tarea);
    }

    public function destroy(Tarea $tarea)
    {
        try {
            $tarea->delete();
            return response()->json(null, 204);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error: ' . $e->getMessage()
            ], 400);
        }
    }



    public function indexByCriterio(Request $request, $criterio_evaluacion_id)
    {
        return TareaResource::collection(
            Tarea::where('criterio_evaluacion_id', $criterio_evaluacion_id)
                ->orderBy($request->_sort ?? 'id', $request->_order ?? 'asc')
                ->paginate($request->perPage)
        );
    }

    public function showByCriterio($criterio_evaluacion_id, $id)
    {
        $tarea = Tarea::where('criterio_evaluacion_id', $criterio_evaluacion_id)
            ->where('id', $id)
            ->firstOrFail();

        return new TareaResource($tarea);
    }

    public function storeByCriterio(Request $request, $criterio_evaluacion_id)
    {
        $tareaData = json_decode($request->getContent(), true);
        $tareaData['criterio_evaluacion_id'] = $criterio_evaluacion_id;

        $tarea = Tarea::create($tareaData);

        return new TareaResource($tarea);
    }

}
