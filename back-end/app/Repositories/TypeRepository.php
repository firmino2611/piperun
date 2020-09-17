<?php

namespace App\Repositories;

use App\Http\Resources\Collections\TypeCollection;
use App\Http\Resources\ErrorResource;
use App\Http\Resources\TypeResource;
use App\Models\Type;
use App\Repositories\Contracts\RepositoryInterface;

class TypeRepository implements RepositoryInterface
{
    protected Type $model;

    public function __construct(Type $model)
    {
        $this->model = $model;
    }

    /**
     * Recupera todos os registro do banco
     * @return mixed
     */
    public function getAll()
    {
        return (new TypeCollection(
                auth()->user()
                    ->types()->orderBy('name')
                    ->get())
            )
            ->response()
            ->setStatusCode(200);
    }

    /**
     * Cria um novo tipo no banco
     * @param array $data
     * @return array|mixed
     */
    public function create(array $data)
    {
        try {
            $type = $this->model->newQuery()->create(array(
                'name' => $data['name'],
                'user_id' => auth()->id()
            ));
            return (new TypeResource($type))
                ->response()
                ->setStatusCode(201);

        } catch (\Exception $error) {
            return new ErrorResource(array(
                'error' => $error->getMessage()
            ));
        }
    }

    /**
     * Atualiza um registro no banco
     * @param int $id
     * @param array $data
     * @return ErrorResource|TypeResource
     */
    public function updateById(int $id, array $data)
    {
        $type = $this->model->newQuery()->find($id);

        if ($type) {
            $type->update(array(
                'name' => $data['name'],
                'user_id' => auth()->id()
            ));
            return new TypeResource($type);
        }

        return new ErrorResource(array(
            'error' => 'Tipo não encontrado',
        ));
    }

    /**
     * Remove do banco um registro
     * @param int $id
     * @return ErrorResource|TypeResource
     */
    public function deleteById(int $id)
    {
        $type = $this->model->newQuery()->find($id);

        if ($type) {
            try {
                if (count($type->tasks))
                    return new ErrorResource([
                        'error' => 'Este item está em uso e não pode ser apagado'
                    ]);

                $type->delete($id);

                return new TypeResource($type);
            } catch (\Exception $e) {
                return new ErrorResource(array(
                    'error' => $e->getMessage(),
                ));
            }

        }
        return new ErrorResource(array(
            'error' => 'Tipo não encontrado',
        ));
    }
}
