<?php

namespace App\Http\Controllers;

use App\Http\Resources\ErrorResource;
use App\Http\Resources\TypeResource;
use App\Repositories\TypeRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TypeController extends Controller
{
    protected TypeRepository $type;

    public function __construct(TypeRepository $type)
    {
        $this->type = $type;
    }

    /**
     * Recupera todos os tipos cadastrados
     * @return JsonResponse
     */
    public function index()
    {
        return $this->type->getAll();
    }

    /**
     * Cria um novo registro de tipo
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        return $this->type->create($request->all());
    }

    /**
     * Atualiza um registro de tipo
     * @param Request $request
     * @param int $id
     * @return ErrorResource|TypeResource
     */
    public function update(Request $request, int $id)
    {
        return $this->type->updateById($id, $request->all());
    }

    /**
     * Excluir um tipo do banco de dados
     * @param $id
     * @return ErrorResource|TypeResource
     */
    public function destroy($id)
    {
        return $this->type->deleteById($id);
    }
}
