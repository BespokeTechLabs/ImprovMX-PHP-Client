<?php


namespace Bespoke\ImprovMX\Api;

use Bespoke\ImprovMX\Entities\Log\Log as LogEntity;
use Illuminate\Support\Collection;

class Log extends AbstractApi
{
    /**
     * Retrieve the logs for a given domain.
     * @param string $domain Name of the domain.
     * @param string|null $nextCursor Loads the logs after the given log.id (optional).
     * @return Collection<LogEntity>
     */
    public function getDomainLogs($domain, $nextCursor = null) {
        try {
            $queryString = "";
            if (!is_null($nextCursor)) $queryString = "?next_cursor=".$nextCursor;

            $response = $this->getRequest("domains/".$domain."/logs".$queryString);

            if (is_null($response)) return new Collection();
            if (!is_array($response)) return new Collection();
            if (!array_key_exists("logs", $response)) return new Collection();

            $entries = array_map(function ($log) {
                return new LogEntity($log);
            }, $response["logs"]);

            return collect($entries);

        } catch (Exception $e) {
            return new Collection();
        }
    }

    /**
     * Retrieve the logs for a given alias in a given domain.
     * @param string $domain Name of the domain.
     * @param string $alias Alias setup for forwarding.
     * @param string|null $nextCursor Loads the logs after the given log.id (optional).
     * @return Collection<LogEntity>
     */
    public function getAliasLogs($domain, $alias, $nextCursor = null) {
        try {
            $queryString = "";
            if (!is_null($nextCursor)) $queryString = "?next_cursor=".$nextCursor;

            $response = $this->getRequest("domains/".$domain."/logs/".$alias.$queryString);

            if (is_null($response)) return new Collection();
            if (!is_array($response)) return new Collection();
            if (!array_key_exists("logs", $response)) return new Collection();

            $entries = array_map(function ($log) {
                return new LogEntity($log);
            }, $response["logs"]);

            return collect($entries);

        } catch (Exception $e) {
            return new Collection();
        }
    }
}
