<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\EvidenciaResource;
use App\Models\Evidencia;
use App\Models\Evidencias;
use Illuminate\Http\Request;

class EvidenciasController extends Controller
{
    public function index(Request $request)
    {
        return EvidenciaResource::collection(
            Evidencia::orderBy($request->_sort ?? 'id', $request->_order ?? 'asc')
            ->paginate($request->perPage));
    }

    public function store(Request $request)
    {
        $evidencia = json_decode($request->getContent(), true);

        $evidencia = Evidencia::create($evidencia);

        return new EvidenciaResource($evidencia);
    }
    public function show(Evidencia $evidencia)
    {
        return new EvidenciaResource($evidencia);
    }

    public function update(Request $request, $tarea_id, Evidencia $evidencia)
{
    $data = $request->all();
    $evidencia->update($data);

    return new EvidenciaResource($evidencia);
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Evidencia $evidencia)
    {
        try {
            $evidencia->delete();
            return response()->json(null, 204);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error: ' . $e->getMessage()
            ], 400);
        }
    }
}
