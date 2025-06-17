<?php

namespace App\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Support\Facades\Auth;

class EntityAccountScope implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $builder
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return void
     */
    public function apply(Builder $builder, Model $model)
    {

        $builder->where(function ($query) {
            $user = Auth::user();
            $entity = $user->myEntity();
            $account = $user->myAccount();
            $entity_id = 0;

            if ($entity )
                $entity_id = $entity->id;

            $query->where('entity_id', '=', $entity_id )
                ->orWhere('account_id', '=', $account->id );
        });

    }
}
