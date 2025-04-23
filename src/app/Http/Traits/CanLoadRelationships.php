<?php

namespace App\Http\Traits;

use Illuminate\Contracts\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Contracts\Database\Query\Builder as QueryBuilder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

trait CanLoadRelationships
{
    public function loadRelationships(
        Model|HasMany|QueryBuilder|EloquentBuilder $for,
        ?array $relations = null
    ){
        $relations = $relations ?? $this->relations ?? [];

        foreach($relations as $relation) {
            if($this->shouldIncludeRelation($relation)){
                if($for instanceof Model){
                    $for->load($relation);
                } else {
                    $for->with($relation);
                }
            }
        }

        return $for;
    }

    public function shouldIncludeRelation(string $relation)
    {
        $include = request()->query('include');

        if(!$include){
            return false;
        }

        $relations = array_map('trim', explode(',', $include));
        return in_array($relation, $relations);
    }


}
