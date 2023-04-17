<?php

namespace App\Base;

class BaseRepository
{
    /**
     * @param BaseEntity $entity
     * @return BaseEntity
     */
    public static function persist(BaseEntity $entity) : BaseEntity
    {
        return $entity->save();
    }
}
