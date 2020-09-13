<?php

namespace App\Http\Controllers;

use App\Repositories\Contracts\RepositoryInterface;
use App\Repositories\TaskRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use PhpParser\Node\Scalar\String_;

class TaskController extends Controller
{
    protected TaskRepository $task;

    public function __construct(TaskRepository $task)
    {
        $this->task = $task;
    }

    /**
     * Recupera todas as atividades
     * @return JsonResponse
     */
    public function index()
    {
        return response()->json(
            $this->task->getAll(),
            200);
    }

    /**
     * Recupera as atividades com inicio dentro o
     * range de datas enviadas
     * @param $start
     * @param $end
     * @return JsonResponse
     * @throws \Exception
     */
    public function filterStart($start, $end)
    {
        return response()->json(
            $this->task->getAllStartDate($start, $end),
            200);
    }

    public function filterEnd($start, $end)
    {
        return response()->json(
            $this->task->getAllEndDate($start, $end),
            200);
    }

    /**
     * Cria uma nova atividade no banco de dados
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        return response()->json(
            $this->task->create($request->all(),
            ), 200);
    }


    /**
     * Atualiza uma atividade especifica
     *
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(Request $request, $id)
    {
        return response()->json(
            $this->task->updateById($id, $request->all(),
            ), 200);
    }

    /**
     * Exclui do banco de dados uma atividade
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy($id)
    {
        return response()->json(
            $this->task->deleteById($id),
            200);
    }
}
