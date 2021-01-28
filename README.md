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

## Security

If you discover a security vulnerability within this package, please send an email to Bespoke Technology Labs at hello@bespoke.dev. All security vulnerabilities will be promptly addressed. You may view our full security policy [here](https://github.com/BespokeTechLabs/ImprovMX-PHP-Client/security/policy).


## License

The ImprovMX API Client Library is licensed under [The MIT License (MIT)](LICENSE).


## Credits

- Lewis Smallwood - Bespoke Technology Labs
