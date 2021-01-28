# ImprovMX API Client

This repo contains the source for a Laravel client library for the [ImprovMX API](https://improvmx.com/api/).

<p align="center">
<a href="LICENSE"><img src="https://img.shields.io/badge/license-MIT-brightgreen?style=flat-square" alt="Software License"></img></a>
<a href="https://packagist.org/packages/bespoke/improvmx"><img src="https://img.shields.io/packagist/dt/bespoke/improvmx?style=flat-square" alt="Packagist Downloads"></img></a>
<a href="https://github.com/BespokeTachLabs/ImprovMX-PHP-Client/releases"><img src="https://img.shields.io/github/release/BespokeTechLabs/ImprovMX-PHP-Client?style=flat-square" alt="Latest Version"></img></a>
</p>

Check out the [change log](CHANGELOG.md), [releases](https://github.com/BespokeTechLabs/ImprovMX-PHP-Client/releases), [license](LICENSE), [code of conduct](.github/CODE_OF_CONDUCT.md), and [contribution guidelines](.github/CONTRIBUTING.md).


## Installation

This version supports [PHP](https://php.net) 7.2-8.0. To get started, simply require the project into an existing Laravel application using [Composer](https://getcomposer.org).

```bash
composer require bespoke/improvmx
```
Follow these [installation instructions](https://getcomposer.org/doc/00-intro.md) if you do not already have `composer` installed.

The project has a service provider which is automatically configured in new versions of Laravel.

To get the project working, simply add your ImprovMX API key into your .env file.

`IMPROVMX_KEY=XXXXXXXXXXXXXX`

## Getting Started

The recommended method for using the ImprovMX client is to access it using the Laravel service provider.

This will construct your client automatically using the API key within your .env file.

```php
$improvMx = new ImprovMx();
$client = $improvMx->client();
```

Alternatively, an ImprovMX client can be constructed manually.

```php
$client = new Bespoke\ImprovMX\Client("INPUT_API_KEY_MANUALLY");
```

Once the client has been constructed, the API can be consumed as follows:
```php
$client->account()->getAccountDetails();
$client->domains()->list();
```

## Example Usage

### Account

```php
$improvMx = new ImprovMX();

// Return the Account entity.
$accountDetails = $improvMx->client()->account()->getAccountDetails();

// Return a collection of white-labelled domains.
$domains = $improvMx->client()->account()->getWhiteLabeledDomains();
```

### Domains

```php
$improvMx = new ImprovMX();

// Return a collection of Domain entities.
$domains = $improvMx->client()->domains()->list();

// Returns the newly created Domain entity or null (if failed to create).
$improvMx->client()->domains()->add("domain.com", "email@email.com", "whitelabel-domain.com");

// Return the Domain entity (or null).
$domain = $improvMx->client()->domains()->get("test.com");

// Update the details for a domain - returns the Domain entity or null.
$improvMx->client()->domains()->update("domain.com", "email@email.com", "whitelabel-domain.com");

// Returns delete successful - true or false.
$success = $improvMx->client()->domains()->delete("domain.com");

// Returns a DomainValidity entity.
$details = $improvMx->client()->domains()->checkDomainValidity("domain.com");
```

### Aliases

```php
$improvMx = new ImprovMX();

// Return a collection of Alias entities for a domain.
$aliases = $improvMx->client()->aliases()->list("domain.com");

// This command sets up email forwarding from user@domain.com to forward@email.com.
// Returns the newly created Alias entity or null (if failed to create).
$improvMx->client()->aliases()->add("domain.com", "user", "forward@email.com");

// Return the Alias entity (or null) for a given alias e.g. (alias@domain.com).
$alias = $improvMx->client()->aliases()->get("domain.com", "alias");

// Update the forwarding address for an alias - returns the Alias entity or null.
$improvMx->client()->aliases()->update("domain.com", "alias", "forward@email.com");

// Returns delete successful - true or false.
$success = $improvMx->client()->aliases()->delete("domain.com", "alias");
```

### Logs

```php
$improvMx = new ImprovMX();

// Return a collection of Log entities for a domain.
$logs = $improvMx->client()->logs()->getDomainLogs("domain.com");

// Return a collection of Log entities for a domain's alias.
$logs = $improvMx->client()->logs()->getAliasLogs("domain.com", "alias");
```

### SMTP Credentials

```php
$improvMx = new ImprovMX();

// Return a collection of Credential entities for a domain.
$credentials = $improvMx->client()->smtpCredentials()->list("domain.com");

// Add a new SMTP account for a domain (returns with the Credential entity or null).
$logs = $improvMx->client()->smtpCredentials()->add("domain.com", "username", "password");

// Update the password for an SMTP account (by username) - returns the Credential entity or null.
$improvMx->client()->smtpCredentials()->update("domain.com", "username", "newPassword");

// Returns delete successful - true or false.
$success = $improvMx->client()->smtpCredentials()->delete("domain.com", "username");
```

## Security

If you discover a security vulnerability within this package, please send an email to Bespoke Technology Labs at hello@bespoke.dev. All security vulnerabilities will be promptly addressed. You may view our full security policy [here](https://github.com/BespokeTechLabs/ImprovMX-PHP-Client/security/policy).


## License

The ImprovMX API Client Library is licensed under [The MIT License (MIT)](LICENSE).


## Credits

- Lewis Smallwood - Bespoke Technology Labs
