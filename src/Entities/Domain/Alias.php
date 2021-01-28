<?php

namespace Bespoke\ImprovMX\Entities\Domain;

use Bespoke\ImprovMX\Entities\AbstractEntity;

class Alias extends AbstractEntity
{
    public $id;
    public $forward;
    public $alias;
}
