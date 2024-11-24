<?php

namespace App\Models\Scopes;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Database\Eloquent\Builder;

class BranchProductsScope implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     */
    public function apply(Builder $builder, Model $model): void
    {
        if (Auth::check()){
            if(Auth::user()->hasRole('سوبر-ادمن')) {
                $builder->get();
            } elseif(Auth::user()->branch_id){
                $branch_id = Auth::user()->branch_id;
                $builder->where('branch_id', $branch_id);
            }
        }

    }
}
