<?php

namespace App\Http\Controllers\AppControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\ModelsApp\AppSuscripcion;
use App\ModelsApp\AppUsuario;
use App\Models\Seccion;
use App\Http\Resources\AppSuscripcionesResource;
use Illuminate\Support\Collection;

class SuscripcionesController extends Controller
{
    public function showSuscripciones($usuario_id){

        $suscripciones_user = Seccion::where('nombre', '<>','')
                                        ->with(['suscripciones' => function ($query) use ($usuario_id) {
                                            $query->where('usuario_id', $usuario_id);
                                        }])
                                        ->get();

        return response()->json(AppSuscripcionesResource::collection($suscripciones_user), 200);
    }

    public function saveSuscripciones($usuario_id, Request $request){

        $user = AppUsuario::find($usuario_id);

        $secciones_true = collect($request)->map(function ($item) {
            return
            [
                'seccion_id' => $item['id_seccion'],
                'status' => $item['status']
            ];
        })
        ->filter(function ($item) {
            return $item['status'] == 1;
        })
        ->map(function ($item) {
            return $item['seccion_id'];
        });

        $user->seccion()->sync($secciones_true);

        $suscripciones_user = Seccion::where('nombre', '<>','')
                                        ->with(['suscripciones' => function ($query) use ($usuario_id) {
                                            $query->where('usuario_id', $usuario_id);
                                        }])
                                        ->get();

        return response()->json(AppSuscripcionesResource::collection($suscripciones_user), 200);
    }
}
