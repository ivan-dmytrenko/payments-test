<?php

namespace App\Repositories\Contracts;

interface RepositoryInterface
{
    public function all();

    public function find($id);

    public function findOrFail($id);

    public function create(array $input);

    public function update($id, array $input);

    public function delete($id);

    public function where(array $parameters, string $field = null, string $order = null);

    public function findWhere($id, array $parameters);

    public function findWhereOrFail($id, array $parameters);

    public function with(array $tables);

    public function firstOrCreate(array $input);
}