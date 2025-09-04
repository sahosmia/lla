<?php

namespace Amentotech\LaraGuppy\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class ActiveScope implements Scope
{
    

     public $columnName;

     public function __construct($columnName)
    {
        $this->columnName = $columnName;
    }

    /**
     * Apply the scope to a given Eloquent query builder.
     */

    public function apply(Builder $builder, Model $model): void
    {
        $builder->where($this->columnName, '=', 'active');
    }
}
