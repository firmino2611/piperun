<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     * @throws Exception
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'responsible' => $this->responsible,
            'description' => $this->description,
            'start_at' => (new Carbon($this->start_at))->format('Y-m-d'),
            'end_at' => (new Carbon($this->end_at))->format('Y-m-d'),
            'finish_at' => $this->finish_at,
            'status' => $this->status,
            'type' => new TypeResource($this->type),
        ];
    }

    /**
     * Configura o código de resposta
     * http padrão para o recurso em questão
     * @param Request $request
     * @param JsonResponse $response
     */
    public function withResponse($request, $response)
    {
        $response->setStatusCode(200);
    }

    public function with($request)
    {
        return [
          'success' => true,
        ];
    }
}
