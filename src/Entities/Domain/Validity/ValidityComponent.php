<?php

namespace Bespoke\ImprovMX\Entities\Domain\Validity;

use Bespoke\ImprovMX\Entities\AbstractEntity;

class ValidityComponent extends AbstractEntity
{
    public function __construct($parameters = null)
    {
        parent::__construct($parameters);

        if (is_null($this->expected)) $this->expected = [];
        if (is_null($this->values)) $this->values = [];

        if (!is_array($this->expected)) $this->expected = [ $this->expected ];
        if (!is_array($this->values)) $this->values = [ $this->values ];
    }

    public $expected = [];
    public $valid = false;
    public $values = [];
}
