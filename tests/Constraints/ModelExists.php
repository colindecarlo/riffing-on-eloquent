<?php

namespace App\Constraints;

use Illuminate\Database\Eloquent\Model;

class ModelExists extends \PHPUnit_Framework_Constraint
{
    protected function matches($model)
    {
        return $model->exists === true;
    }

    public function toString()
    {
        return 'model exists';
    }
}
