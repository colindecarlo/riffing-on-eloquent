<?php

namespace App\Constraints;

class ModelEquals extends \PHPUnit_Framework_Constraint_ArraySubset
{
    /**
     * @inheritdoc
     */
    public function toString()
    {
        return 'has the attributes ' . $this->exporter->export($this->subset);
    }

    /**
     * @inheritdoc
     */
    protected function failureDescription($other)
    {
        return 'the model ' . $this->toString() . ' (actual attributes) ' . $this->exporter->export($other);
    }
}
