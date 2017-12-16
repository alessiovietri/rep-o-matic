<?php

namespace App\Repositories\Contracts;

interface ENTITYNAMERepository {

    public function getAll();

    public function create(array $attributes);

    public function update($id, array $attributes);

    public function delete($id);

    public function find($Id);

}