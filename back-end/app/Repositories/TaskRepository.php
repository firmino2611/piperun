<?php /** @noinspection PhpUndefinedClassInspection */

namespace App\Repositories;

use App\Http\Resources\Collections\TaskCollection;
use App\Http\Resources\ErrorResource;
use App\Http\Resources\TaskResource;
use App\Models\Task;
use App\Repositories\Contracts\RepositoryInterface;
use Carbon\Carbon;
use Exception;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use TaskValidation;

class TaskRepository implements RepositoryInterface
{
    protected Task $model;

    public function __construct(Task $model)
    {
        $this->model = $model;
    }

    /**
     * Recupera as atividades dentro do intervalo definido
     * para o inicio da atividade
     * @param $start
     * @param $end
     * @return TaskCollection|ErrorResource
     * @throws Exception
     */
    public function getAllStartDate($start, $end)
    {
        if (dateEndIsValid($start, $end))
            return new ErrorResource(array(
                'error' => 'O prazo deve ser em uma data acima da data de inicio',
            ));

        return new TaskCollection(auth()->user()->tasks()->with('type')
            ->whereDate('start_at', '>=', getOnlyDate($start))
            ->whereDate('start_at', '<=', getOnlyDate($end))
            ->orderBy('start_at', 'desc')
            ->paginate(10));

    }

    /**
     * Recupera as atividades dentro do intervalo definido
     * para o prazo da atividade
     * @param $start
     * @param $end
     * @return TaskCollection|ErrorResource
     * @throws Exception
     */
    public function getAllEndDate($start, $end)
    {
        if (dateEndIsValid($start, $end))
            return new ErrorResource(array(
                'error' => 'A data final deve ser em uma data acima da data de inicio',
            ));
        return new TaskCollection(auth()->user()->tasks()->with('type')
            ->whereDate('end_at', '>=', getOnlyDate($start))
            ->whereDate('end_at', '<=', getOnlyDate($end))
            ->orderBy('start_at', 'desc')
            ->paginate(10));

    }

    /**
     * Recupera todos os registros do banco
     * @return TaskCollection
     */
    public function getAll()
    {
        return new TaskCollection(auth()->user()->tasks()
            ->orderBy('start_at', 'desc')
            ->paginate(10));
    }


    /**
     * Cria uma nova tarefa no banco de dados
     * @param array $data
     * @return \Illuminate\Http\JsonResponse|object
     */
    public function create(array $data)
    {
        $conflicts = $this->checkConflictDates(
            $data['start_at'],
            $data['end_at']
        );

        if (count($conflicts)) {
            return new ErrorResource(array(
                'error' => 'Conflito de datas',
            ));
        }
        // Caso não exista conflito de datas prossegue o cadastro no banco
        // Verificar se data não caiu em um final de semana
        try {
            $validation = TaskValidation::validate($data);
            if ($validation['success']) {
                $task = $this->model->newQuery()
                    ->create(array(
                        'description' => $data['description'],
                        'responsible' => $data['responsible'],
                        'start_at' => new Carbon($data['start_at']),
                        'end_at' => new Carbon($data['end_at']),
                        'status' => $data['status'],
                        'type_id' => $data['type'] ?? $data['type_id'],
                        'user_id' => auth()->id(),
                    ));

                return (new TaskResource($task))->response()->setStatusCode(201);
            }
            return new ErrorResource($validation);

        } catch (Exception $e) {
            return new ErrorResource(array(
                'error' => $e->getMessage(),
                'success' => false
            ));
        }
    }

    /**
     * Verifica se existem atividades conflitantes
     * com a data de ínicio e prazo final
     * @param String $start
     * @param String $end
     * @param null $taskID
     * @return bool|array
     */
    private function checkConflictDates($start, $end, $taskID = null)
    {
        try {
            // Tenta recuperar atividades conflitantes com a data de inicio e prazo final
            $taskOfUser = auth()->user()->tasks()
                ->whereDate('start_at', '<=', $start)
                ->whereDate('end_at', '>=', $start)
                ->orWhereDate('start_at', '<=', $end)
                ->whereDate('end_at', '>=', $end)
                ->get();

            if (count($taskOfUser)) {
                foreach ($taskOfUser as $index => $task)
                    if ($taskID == $task->id)
                        unset($taskOfUser[$index]);

                return $taskOfUser;
            }

            return [];
        } catch (Exception $err) {
            return [];
        }
    }

    /**
     * Atualiza um registro do banco de dados
     * @param int $task
     * @param array $data
     * @return ErrorResource|TaskResource
     */
    public function updateById(int $task, array $data)
    {
        // Caso não exista conflito de datas prossegue o cadastro no banco
        // Verificar se data não caiu em um final de semana
        try {
            $task = $this->model->newQuery()->find($task);

            if ($task) {
                if (TaskValidation::hasChangeDates($task, $data)) {
                    $validation = TaskValidation::validate($data);

                    if (!$validation['success']) {
                        return new ErrorResource($validation);
                    }

                    $conflicts = $this->checkConflictDates(
                        $data['start_at'],
                        $data['end_at'],
                        $task->id
                    );

                    if (count($conflicts)) {
                        return new ErrorResource([
                            'error' => 'Conflito de datas',
                            'success' => false
                        ]);
                    }
                }
                $task->update(array(
                    'description' => $data['description'],
                    'responsible' => $data['responsible'],
                    'start_at' => new Carbon($data['start_at']),
                    'end_at' => new Carbon($data['end_at']),
                    'finish_at' => $data['finish_at'] ?? $task->finish_at,
                    'status' => $data['status'],
                    'type_id' => $data['type'] ?? $task->type_id,
                    'user_id' => auth()->id(),
                ));
                return new TaskResource($task);
            }

            return new ErrorResource(array(
                'error' => 'Atividade não encontrada',
                'success' => false
            ));
        } catch (Exception $e) {
            return new ErrorResource(array(
                'error' => $e->getMessage(),
                'success' => false
            ));
        }
    }

    /**
     * Remove um registro do banco de dados
     * @param int $id
     * @return array|bool|mixed|null
     */
    public function deleteById(int $id)
    {
        try {
            $task = $this->model->newQuery()->find($id);
            $task->delete();

            return new TaskResource($task);
        } catch (Exception $e) {
            return new ErrorResource(array(
                'error' => $e->getMessage(),
            ));
        }
    }

}
