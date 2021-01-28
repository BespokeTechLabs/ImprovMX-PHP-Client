<?php

namespace Bespoke\ImprovMX\Entities\Account;

use Bespoke\ImprovMX\Entities\AbstractEntity;

class AccountPlan extends AbstractEntity
{
    public $aliasesLimit;
    public $dailyQuota;
    public $display;
    public $domainsLimit;
    public $kind;
    public $name;
    public $price;
    public $yearly;
}
