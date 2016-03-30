<?php

use App\Constraints\ModelEquals;
use App\Constraints\ModelExists;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Support\Arrayable;

trait Asserts
{
    public static function assertModelExists($model, $message = '')
    {
        if (! $model instanceof Model) {
            throw PHPUnit_Util_InvalidArgumentHelper::factory(1, 'Eloquent Model', $model);
        }

        self::assertThat($model, new ModelExists, $message);
    }

    public static function assertModelEquals($expected, $actual, $message = '')
    {
        if (! is_array($expected) || $expected instanceof Arrayable) {
            throw PHPUnit_Util_InvalidArgumentHelper::factory(1, 'array or Eloquent Model', $expected);
        }
        
        if (! $actual instanceof Model) {
            throw PHPUnit_Util_InvalidArgumentHelper::factory(2, 'Eloquent Model', $actual);
        }

        $expected = is_array($expected) ? $expected : $expected->attributesToArray();
        $constraint = new ModelEquals($expected);

        self::assertThat($actual->attributesToArray(), $constraint, $message);
    }
}
