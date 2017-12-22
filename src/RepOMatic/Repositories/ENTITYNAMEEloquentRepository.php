<?php

namespace App\Repositories\ENTITYNAME;

use App\Repositories\Contracts\ENTITYNAMERepository;

use App\Models\ENTITYNAME as ENTITYNAME;

use App\Exceptions\ENTITYNAME\ENTITYNAMENotCreatedException;
use App\Exceptions\ENTITYNAME\ENTITYNAMENotUpdatedException;
use App\Exceptions\ENTITYNAME\ENTITYNAMENotDeletedException;
use App\Exceptions\ENTITYNAME\ENTITYNAMENotFoundException;

class ENTITYNAMEEloquentRepository implements ENTITYNAMERepository
{
    /**
     * Retrieve all ENTITYNAMEs instances
     *
     * @return mixed
     */
    public static function getAll()
    {
        $allENTITYNAMEs = ENTITYNAME::all();

        return $allENTITYNAMEs;
    }

    /**
     * Create a ENTITYNAME instance
     *
     * @param array $attributes
     * @return mixed
     * @throws ENTITYNAMENotCreatedException
     */
    public static function create(array $attributes)
    {
        $aENTITYNAME = new ENTITYNAME;

        foreach($attributes as $name => $value){
            $aENTITYNAME->{$name} = $value;
        }

        if(!$aENTITYNAME->save())
            throw new ENTITYNAMENotCreatedException;

        return $aENTITYNAME;
    }

    /**
     * Update a ENTITYNAME instance
     *
     * @param $id
     * @param array $attributes
     * @return mixed
     * @throws ENTITYNAMENotUpdatedException
     */
    public static function update($id, array $attributes)
    {
        try{
            $aENTITYNAME = find($id);

            foreach($attributes as $name => $value){
                $aENTITYNAME->{$name} = $value;
            }

            if(!$aENTITYNAME->save())
                throw new ENTITYNAMENotUpdatedException;
        }
        catch(ENTITYNAMENotFoundException $e){
            throw new ENTITYNAMENotUpdatedException;
        }

        return $aENTITYNAME;
    }

    /**
     * Delete a ENTITYNAME instance
     *
     * @param $id
     * @return bool
     * @throws ENTITYNAMENotDeletedException
     * @throws ENTITYNAMENotFoundException
     */
    public static function delete($id)
    {
        if(!find($id)->delete())
            throw new ENTITYNAMENotDeletedException;
        return true;
    }

    /**
     * Find a ENTITYNAME instance by ID
     *
     * @param $id
     * @return mixed
     * @throws ENTITYNAMENotFoundException
     */
    public static function find($id)
    {
        $aENTITYNAME = ENTITYNAME::where('id', '=', $id)
            ->first();

        if ($aENTITYNAME === null)
            throw new ENTITYNAMENotFoundException;

        return $aENTITYNAME;
    }
}