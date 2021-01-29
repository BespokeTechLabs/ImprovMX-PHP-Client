<?php


namespace Bespoke\ImprovMX\Api;

use \Bespoke\ImprovMX\Entities\Domain\Alias as AliasEntity;
use Illuminate\Support\Collection;

class Alias extends AbstractApi
{
    /**
     * List aliases for a given domain.
     * @param string $domain Name of the domain.
     * @param string|null $query Search the aliases starting by this value.
     * @param bool|null $isActive Return only active (1) or inactive (0) aliases (optional).
     * @return Collection<AliasEntity>
     */
    public function list($domain, $query = null, $isActive = null) {
        try {
            $aliases = [];
            $totalPages = 1;
            $numberPerPage = 100;

            for ($i = 1; $i <= $totalPages; $i++) {
                try {
                    $queryString = "";
                    if (!is_null($query)) $queryString = "&q=".$query;
                    if (!is_null($isActive)) $queryString .= "&is_active=".intval($isActive);

                    $response = $this->getRequest("domains/".$domain."/aliases?page=".$i."&limit=".$numberPerPage.$queryString);

                    if (is_null($response)) break;
                    if (!is_array($response)) break;
                    if (!array_key_exists("aliases", $response)) break;

                    $entries = array_map(function ($domain) {
                        return new AliasEntity($domain);
                    }, $response["aliases"]);

                    $aliases = array_merge($aliases, $entries);

                    $totalPages = ceil($response["total"] / $numberPerPage);

                } catch (Exception $e) {
                    break;
                }
            }

            return collect($aliases);

        } catch (Exception $e) {
            return new Collection();
        }
    }

    /**
     * Add a new alias to a given domain.
     * @param string $domain Name of the domain.
     * @param string $alias Alias to be used in front of your domain, like “contact”, “info”, etc.
     * @param string $forward Destination email to forward the emails to.
     * @return AliasEntity|null
     */
    public function add($domain, $alias, $forward) {
        try {
            $payload = [
                "alias" => $alias,
                "forward" => $forward
            ];

            $response = $this->postRequest("domains/".$domain."/aliases", $payload);

            if (is_null($response)) return null;
            if (!is_array($response)) return null;
            if (!array_key_exists("alias", $response)) return null;

            return new AliasEntity($response["alias"]);

        } catch (Exception $e) {
            return null;
        }
    }

    /**
     * Get the details of a given alias.
     * @param string $domain Name of the domain.
     * @param string $alias Alias setup for forwarding.
     * @return AliasEntity|null
     */
    public function get($domain, $alias) {
        try {
            $response = $this->getRequest("domains/".$domain."/aliases/".$alias);

            if (is_null($response)) return null;
            if (!is_array($response)) return null;
            if (!array_key_exists("alias", $response)) return null;

            return new AliasEntity($response["alias"]);

        } catch (Exception $e) {
            return null;
        }
    }

    /**
     * Update a given alias for a domain.
     * @param string $domain Name of the domain.
     * @param string $alias Alias setup for forwarding.
     * @param string $forward Destination email to forward the emails to.
     * @return AliasEntity|null
     */
    public function update($domain, $alias, $forward) {
        $payload = [
            "forward" => $forward
        ];

        try {
            $response = $this->putRequest("domains/".$domain."/aliases/".$alias, $payload);

            if (is_null($response)) return null;
            if (!is_array($response)) return null;
            if (!array_key_exists("alias", $response)) return null;

            return new AliasEntity($response["alias"]);

        } catch (Exception $e) {
            return null;
        }
    }

    /**
     * Delete a given alias for a domain.
     * @param string $domain Name of the domain.
     * @param string $alias Alias setup for forwarding.
     * @return bool successfully deleted?
     */
    public function delete($domain, $alias) {
        try {
            $response = $this->deleteRequest("domains/".$domain."/aliases/".$alias);

            if (is_null($response)) return false;
            if (!is_array($response)) return false;
            if (!array_key_exists("success", $response)) return false;
            if (!is_bool($response["success"])) return false;

            return $response["success"];

        } catch (Exception $e) {
            return false;
        }
    }
}
