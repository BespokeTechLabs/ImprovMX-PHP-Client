<?php

namespace Bespoke\ImprovMX\Entities\Account;

use Bespoke\ImprovMX\Entities\AbstractEntity;

class AccountLimits extends AbstractEntity
{
    public $aliases;
    public $dailyQuota;
    public $domains;
    public $ratelimit;
    public $redirections;
    public $subdomains;
}
