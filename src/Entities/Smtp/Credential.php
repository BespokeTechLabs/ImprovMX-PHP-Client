<?php

namespace Bespoke\ImprovMX\Entities\Smtp;

use Bespoke\ImprovMX\Entities\AbstractEntity;
use Illuminate\Support\Carbon;

class Credential extends AbstractEntity
{
    public function __construct($parameters = null)
    {
        parent::__construct($parameters);
        $this->created = Carbon::createFromTimestamp($this->created / 1000);
    }

    public $created;
    public $usage;
    public $username;
}
