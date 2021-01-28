<?php

namespace Bespoke\ImprovMX\Entities\Account;

use Bespoke\ImprovMX\Entities\AbstractEntity;
use Illuminate\Support\Carbon;

class Account extends AbstractEntity
{
    public function __construct($parameters = null)
    {
        parent::__construct($parameters);

        if (!is_null($this->plan)) $this->plan = new AccountPlan($this->plan);
        if (!is_null($this->limits)) $this->limits = new AccountLimits($this->limits);
        $this->created = Carbon::createFromTimestamp($this->created / 1000);
    }

    public $billingEmail;
    public $cancelsOn;
    public $cardBrand;
    public $companyDetails;
    public $companyName;
    public $companyVat;
    public $country;
    public $created;
    public $email;
    public $last4;
    public $limits;
    public $lockReason;
    public $locked;
    public $password;
    public $plan;
    public $premium;
    public $privacyLevel;
    public $renewDate;
}
