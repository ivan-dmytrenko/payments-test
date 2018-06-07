<?php

namespace App\Repositories;

use App\Repositories\Contracts\RepositoryInterface;

abstract class Repository implements RepositoryInterface
{
    protected $model;

    protected $with = [];

    public function all()
    {
        $response = $this->model->with($this->with)->get();
        $this->with = [];
        return $response;
    }

    public function find($id)
    {
        $response = $this->model->with($this->with)->find($id);
        $this->with = [];
        return $response;
    }

    public function findOrFail($id)
    {
        $response = $this->model->with($this->with)->findOrFail($id);
        $this->with = [];
        return $response;
    }

    public function create(array $input)
    {
        return $this->model->create($input);
    }

    public function fill(array $input)
    {
        return $this->model->fill($input);
    }

    public function update($id, array $input)
    {
        return $this->model->find($id)->update($input);
    }

    public function delete($id)
    {
        return $this->model->destroy($id);
    }

    public function where(array $parameters, string $field = null, string $order = null)
    {
        $query = $this->model->with($this->with)->where($parameters);
        if ($order) {
            $query->orderBy($field, $order);
        }
        $response = $query->get();
        $this->with = [];
        return $response;
    }

    public function whereWhereIn(
        array $parameters,
        string $whereInKey,
        array $whereInParams,
        string $field = null,
        string $order = null
    )
    {
        $query = $this->model->with($this->with)->where($parameters)->whereIn($whereInKey, $whereInParams);
        if ($order) {
            $query->orderBy($field, $order);
        }
        $response = $query->get();
        $this->with = [];
        return $response;
    }

    public function findWhere($id, array $parameters)
    {
        $response = $this->model->with($this->with)->where($parameters)->find($id);
        $this->with = [];
        return $response;
    }

    public function findWhereOrFail($id, array $parameters)
    {
        $response = $this->model->with($this->with)->where($parameters)->findOrFail($id);
        $this->with = [];
        return $response;
    }

    public function with(array $tables)
    {
        $this->with = $tables;
        return $this;
    }

    public function firstOrCreate(array $input)
    {
        return $this->model->firstOrCreate($input);
    }
}