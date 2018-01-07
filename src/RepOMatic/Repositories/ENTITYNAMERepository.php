<?php

namespace App\Repositories\Contracts;

interface ENTITYNAMERepository {

    public static function getAll();

    public static function create(array $attributes);

    public static function update($id, array $attributes);

    public static function delete($id);

    public static function find($id);

}