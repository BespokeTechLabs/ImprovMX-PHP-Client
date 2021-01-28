<?php

namespace Bespoke\ImprovMX\Entities\Domain\Validity;

use Bespoke\ImprovMX\Entities\AbstractEntity;

class RecordValidity extends AbstractEntity
{
    public function __construct($parameters = null)
    {
        parent::__construct($parameters);

        $this->dkim1 = new ValidityComponent($this->dkim1);
        $this->dkim2 = new ValidityComponent($this->dkim2);
        $this->dmarc = new ValidityComponent($this->dmarc);
        $this->mx = new ValidityComponent($this->mx);
        $this->spf = new ValidityComponent($this->spf);
    }

    public $dkim1;
    public $dkim2;
    public $dmarc;
    public $mx;
    public $spf;

    public $provider;
    public $error;
    public $advanced = false;
    public $valid = false;
}
