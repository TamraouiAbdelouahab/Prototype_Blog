<?php

namespace Modules\Blog\Services;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;

abstract class BaseService
{
    protected Model $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }


    public function getAll(): Collection
    {
        return $this->model->all();
    }


    public function paginate(int $perPage = 10)
    {
        return $this->model->paginate($perPage);
    }


    public function find(int $id): ?Model
    {
        return $this->model->find($id);
    }


    public function create(array $data): Model
    {
        return $this->model->create($data);
    }


    public function update(int $id, array $data): ?Model
    {
        $record = $this->find($id);
        if ($record) {
            $record->update($data);
            return $record;
        }
        return null;
    }


    public function delete(int $id): bool
    {
        $record = $this->find($id);
        return $record ? $record->delete() : false;
    }
}
