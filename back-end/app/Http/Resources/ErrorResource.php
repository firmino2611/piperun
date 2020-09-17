<?php

namespace App\Http\Resources;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ErrorResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'error' => $this['error'],
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
        $response->setStatusCode(400);
    }

    public function with($request)
    {
        return [
            'success' => false,
        ];
    }
}
