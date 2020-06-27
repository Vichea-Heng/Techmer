<?php

namespace App\Traits;

use App\Exceptions\MessageException;

trait AuthIdField
{
    public function save(array $options = array())
    {

        if (property_exists($this, 'authIdFields')) {
            if (!is_array($this->authIdFields)) {
                throw new MessageException("\$checkBeforeRestore must be an array");
            }

            foreach ($this->authIdFields as $field)
                $this->$field = 1;
            // $this->$field = auth()->id();
        }

        return parent::save($options);
    }
}
