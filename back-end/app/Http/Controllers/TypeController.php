<?php

namespace App\Http\Controllers;

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
        return response()->json(
            $this->type->getAll(),
            200
        );
    }

    /**
     * Cria um novo registro de tipo
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        return response()->json(
            $this->type->create($request->all()),
            200
        );
    }

    /**
     * Atualiza um registro de tipo
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(Request $request, int $id)
    {
        return response()->json(
            $this->type->updateById($id, $request->all()),
            200
        );
    }

    /**
     * Excluir um tipo do banco de dados
     * @param $id
     * @return JsonResponse
     */
    public function destroy($id)
    {
        return response()->json(
            $this->type->deleteById($id),
            200
        );
    }
}
