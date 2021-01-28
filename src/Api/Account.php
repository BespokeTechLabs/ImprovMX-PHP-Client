<?php

namespace Bespoke\ImprovMX\Api;

use Illuminate\Support\Collection;
use Bespoke\ImprovMX\Entities\Account\Account as AccountEntity;

class Account extends AbstractApi
{
    /**
     * Get the details about your ImprovMX account.
     * @return AccountEntity
     */
    public function getAccountDetails()
    {
        try {
            $response = $this->getRequest("account");
            return new AccountEntity($response["account"]);

        } catch (Exception $e) {
            return null;
        }
    }

    /**
     * Get the list of white-labeled domains currently used by your account.
     * @return Collection
     */
    public function getWhiteLabeledDomains()
    {
        try {
            $response = $this->getRequest("account/whitelabels");

            $key = "name";
            $response["whitelabels"] = array_map(function($item) use ($key) {
                return $item[$key];
            }, $response["whitelabels"]);

            return collect($response["whitelabels"]);

        } catch (Exception $e) {
            return new Collection();
        }
    }
}
