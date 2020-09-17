<?php

namespace App\Http\Controllers;

use App\Http\Resources\Collections\TaskCollection;
use App\Http\Resources\ErrorResource;
use App\Http\Resources\TaskResource;
use App\Repositories\TaskRepository;
use Exception;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    protected TaskRepository $task;

    public function __construct(TaskRepository $task)
    {
        $this->task = $task;
    }

    /**
     * Recupera todas as atividades
     * @return LengthAwarePaginator
     */
    public function index()
    {
        return $this->task->getAll();
    }

    /**
     * Recupera as atividades com inicio dentro o
     * range de datas enviadas
     * @param $start
     * @param $end
     * @return array|string[]
     * @throws Exception
     */
    public function filterStart($start, $end)
    {
        return $this->task->getAllStartDate($start, $end);
    }

    /**
     * Recupera as atividades com prazo dentro o
     * range de datas enviadas
     * @param $start
     * @param $end
     * @return array|string[]
     * @throws Exception
     */
    public function filterEnd($start, $end)
    {
        return $this->task->getAllEndDate($start, $end);
    }

    /**
     * Cria uma nova atividade no banco de dados
     *
     * @param Request $request
     * @return ErrorResource|TaskResource
     */
    public function store(Request $request)
    {
        return $this->task->create($request->all());
    }

    /**
     * Atualiza uma atividade especifica
     *
     * @param Request $request
     * @param int $id
     * @return TaskResource
     */
    public function update(Request $request, $id)
    {
        return $this->task->updateById($id, $request->all());
    }

    /**
     * Exclui do banco de dados uma atividade
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy($id)
    {
        return $this->task->deleteById($id);
    }
}
