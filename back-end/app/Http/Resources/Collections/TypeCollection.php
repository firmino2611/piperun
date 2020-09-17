<?php

namespace App\Http\Resources\Collections;

use App\Http\Resources\TypeResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class TypeCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return TypeResource::collection($this->collection)
                ->toArray($request);
    }
}
