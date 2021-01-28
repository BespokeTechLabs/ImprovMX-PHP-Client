<?php


namespace Bespoke\ImprovMX\Api;


use Bespoke\ImprovMX\Entities\Smtp\Credential;
use Illuminate\Support\Collection;

class SmtpCredential extends AbstractApi
{
    /**
     * Returns a list of SMTP accounts for the given domain.
     * @param string $domain Name of the domain.
     * @return Collection<SmtpCredential>
     */
    public function list($domain) {
        try {
            $response = $this->getRequest("domains/".$domain."/credentials");

            $entries = array_map(function ($log) {
                return new Credential($log);
            }, $response["credentials"]);

            return collect($entries);

        } catch (Exception $e) {
            return new Collection();
        }
    }

    /**
     * Add a new SMTP account to send emails.
     * @param string $domain Name of the domain.
     * @param string $username Left part of the mailbox, like bighead for the email bighead@piedpiper.com.
     * @param string $password The password for this account.
     * @return Credential|null
     */
    public function add($domain, $username, $password) {
        try {
            $payload = [
                "username" => $username,
                "password" => $password
            ];

            $response = $this->postRequest("domains/".$domain."/credentials", $payload);

            return new Credential($response["credential"]);

        } catch (Exception $e) {
            return null;
        }
    }

    /**
     * Change the password for a given user.
     * @param string $domain Name of the domain.
     * @param string $username Left part of the mailbox, like bighead for the email bighead@piedpiper.com.
     * @param string $newPassword The new password for this account.
     * @return Credential|null
     */
    public function update($domain, $username, $newPassword) {
        $payload = [
            "password" => $newPassword
        ];

        try {
            $response = $this->putRequest("domains/".$domain."/credentials/".$username, $payload);
            return new Credential($response["credential"]);

        } catch (Exception $e) {
            return null;
        }
    }

    /**
     * Deletes the given SMTP user.
     * @param string $domain Name of the domain.
     * @param string $username The username of the SMTP user to delete.
     * @return bool successfully deleted?
     */
    public function delete($domain, $username) {
        try {
            $response = $this->deleteRequest("domains/".$domain."/credentials/".$username);

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
