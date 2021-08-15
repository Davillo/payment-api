<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

abstract class BaseRepository
{
    protected Model $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function store(array $data): Model
    {
        return $this->model->create($data);
    }

    public function getById(int $id): Model
    {
        return $this->model->find($id);
    }

    public function getAll(): Collection
    {
        return $this->model->all();
    }

    public function update(int $id, array $data): Model
    {
        $model = $this->getById($id);
        $model->update($data);
        return $model;
    }

    public function exists(int $id): bool
    {
        return (bool) $this->getById($id);
    }

    function destroy(int $id): void
    {
        $model = $this->getById($id);
        $model->delete();
    }
}
