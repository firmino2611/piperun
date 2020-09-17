<?php

namespace App\Http\Resources;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TypeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'name' => $this->name,
            'id' => $this->id,
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

    /**
     * Adiciona o campo que identifica a
     * resposta como concluida com sucesso
     * @param Request $request
     * @return array|bool[]
     */
    public function with($request)
    {
        return [
            'success' => true,
        ];
    }

}
