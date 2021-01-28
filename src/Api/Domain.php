<?php

namespace Bespoke\ImprovMX\Api;

use Exception;
use Illuminate\Support\Collection;
use Bespoke\ImprovMX\Entities\Domain\Domain as DomainEntity;

class Domain extends AbstractApi
{
    /**
     * Retrieve a list of all your domains.
     * @param string|null $query Search the domains starting by this value (optional).
     * @param bool|null $isActive Return only active (1) or inactive (0) domains (optional).
     * @return Collection<DomainEntity>
     */
    public function list($query = null, $isActive = null) {
        try {
            $domains = [];
            $totalPages = 1;
            $numberPerPage = 100;

            for ($i = 1; $i <= $totalPages; $i++) {
                try {
                    $queryString = "";
                    if (!is_null($query)) $queryString = "&q=".$query;
                    if (!is_null($isActive)) $queryString .= "&is_active=".intval($isActive);

                    $response = $this->getRequest("domains?page=".$i."&limit=".$numberPerPage.$queryString);

                    $entries = array_map(function ($domain) {
                        return new DomainEntity($domain);
                    }, $response["domains"]);

                    $domains = array_merge($domains, $entries);

                    $totalPages = ceil($response["total"] / $numberPerPage);

                } catch (Exception $e) {
                    break;
                }
            }

            return collect($domains);

        } catch (Exception $e) {
            return new Collection();
        }
    }

    /**
     * Add a new domain.
     * @param string $domain Name of the domain.
     * @param string|null $notificationEmail Email to send the notifications to.
     * @param string|null $whitelabel Parent’s domain that will be displayed for the DNS settings.
     * @return DomainEntity|null false or Domain instance
     */
    public function add($domain, $notificationEmail = null, $whitelabel = null) {
        try {
            $payload = [];
            $payload["domain"] = $domain;
            if (!is_null($notificationEmail)) $payload["notification_email"] = $notificationEmail;
            if (!is_null($whitelabel)) $payload["whitelabel"] = $whitelabel;

            $response = $this->postRequest("domains", $payload);

            return new DomainEntity($response["domain"]);

        } catch (Exception $e) {
            return null;
        }
    }

    /**
     * Get the details of a domain.
     * @param string $domain Name of the domain.
     * @return DomainEntity|null
     */
    public function get($domain) {
        try {
            $response = $this->getRequest("domains/".$domain);
            return new DomainEntity($response["domain"]);

        } catch (Exception $e) {
            return null;
        }
    }

    /**
     * Edit a domain.
     * @param string $domain Name of the domain.
     * @param string|null $newNotificationEmail Email where the notifications related to this domain will be sent.
     * @param string|null $newWhiteLabel The parent’s domain owner.
     * @return DomainEntity|null
     */
    public function update($domain, $newNotificationEmail = null, $newWhiteLabel = null) {
        $payload = [];
        if (!is_null($newNotificationEmail)) $payload["notification_email"] = $newNotificationEmail;
        if (!is_null($newWhiteLabel)) $payload["whitelabel"] = $newWhiteLabel;

        try {
            $response = $this->putRequest("domains/".$domain, $payload);
            return new DomainEntity($response["domain"]);

        } catch (Exception $e) {
            return null;
        }
    }

    /**
     * Delete a given domain.
     * @param string $domain Name of the domain.
     * @return bool successfully deleted?
     */
    public function delete($domain) {
        try {
            $response = $this->deleteRequest("domains/".$domain);

            if (is_null($response)) return false;
            if (!is_array($response)) return false;
            if (!array_key_exists("success", $response)) return false;
            if (!is_bool($response["success"])) return false;

            return $response["success"];

        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * Checks if the MX entries are valid for a domain.
     * @param string $domain Name of the domain.
     * @return DomainValidity|null
     */
    public function checkDomainValidity($domain) {
        try {
            $response = $this->getRequest("domains/".$domain."/check");
            return new DomainValidity($response);

        } catch (Exception $e) {
            return null;
        }
    }
}
