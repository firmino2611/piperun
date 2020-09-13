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

    public function store(Request $request)
    {
        return response()->json(
            $this->type->create($request->all()),
            200
        );
    }

    public function update(Request $request, int $id)
    {
        return response()->json(
            $this->type->updateById($id, $request->all()),
            200
        );
    }

    public function destroy($id)
    {
        return response()->json(
            $this->type->deleteById($id),
            200
        );
    }
}
