<?php

namespace Bespoke\ImprovMX\Entities\Domain;

use Bespoke\ImprovMX\Entities\AbstractEntity;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

class Domain extends AbstractEntity
{
    public function __construct($parameters = null)
    {
        parent::__construct($parameters);

        $this->added = Carbon::createFromTimestamp($this->added / 1000);

        if (is_null($this->aliases)) {
            $this->aliases = new Collection();
        } else {
            $this->aliases = array_map(function ($alias) {
                return new Alias($alias);
            }, $this->aliases);
        }
    }

    public $active;
    public $domain;
    public $display;
    public $dkimSelector;
    public $notificationEmail;
    public $whitelabel;
    public $added;
    public $aliases;
}
