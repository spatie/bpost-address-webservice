# An API wrapper for bpost's address webservice

[![Latest Version on Packagist](https://img.shields.io/packagist/v/spatie/bpost-address-webservice.svg?style=flat-square)](https://packagist.org/packages/spatie/bpost-address-webservice)
[![Build Status](https://img.shields.io/travis/spatie/bpost-address-webservice/master.svg?style=flat-square)](https://travis-ci.org/spatie/bpost-address-webservice)
[![Quality Score](https://img.shields.io/scrutinizer/g/spatie/bpost-address-webservice.svg?style=flat-square)](https://scrutinizer-ci.com/g/spatie/bpost-address-webservice)
[![StyleCI](https://github.styleci.io/repos/163304747/shield?branch=master)](https://github.styleci.io/repos/163304747)
[![Total Downloads](https://img.shields.io/packagist/dt/spatie/bpost-address-webservice.svg?style=flat-square)](https://packagist.org/packages/spatie/bpost-address-webservice)

The Belgian mail service, Bpost, has an API to 

Create an `\Spatie\BpostAddressWebservice\Address`, and validate it.

```php
$addressValidator = AddressValidator::create();

$address = Address::create([
    'streetName' => 'Samberstraat',
    'streetNumber' => '69',
    'boxNumber' => 'D',
    'postalCode' => '2060',
    'municipalityName' => 'Antwaarpe',
    'country' => 'BELGIE',
]);

$validatedAddress = $addressValidator->validate($address);
```

The validated address can contain *errors* and *warnings*. If it has any *error* or *warning*, we say that it has *issues*.

```php
$validatedAddress->hasErrors(); // false

$validatedAddress->hasWarnings(); // true

$validatedAddress->hasIssues(); // true
```

An array of errors, warnings, or issues can be retrieved from the validated address.

```php
$validatedAddress->errors(); // []

$validatedAddress->warnings()[0]->attribute(); // 'municipalityName'
$validatedAddress->warnings()[0]->message(); // 'anomaly_in_field'

$validatedAddress->issues()[0]->attribute(); // 'municipalityName'
$validatedAddress->issues()[0]->message(); // 'anomaly_in_field'
```

A validated addresses' attributes can be retrieved.

```php
$validatedAddress->streetName; // 'Samberstraat'
$validatedAddress->streetNumber; // '69'
$validatedAddress->boxNumber; // ''
$validatedAddress->postalCode; // '2060'
$validatedAddress->municipalityName; // 'Antwaarpe'
$validatedAddress->country; // 'BELGIE'

$validatedAddress->toArray();
// [
//     'streetName' => 'SAMBERSTRAAT',
//     'streetNumber' => '69',
//     'boxNumber' => '',
//     'postalCode' => '2060',
//     'municipalityName' => 'ANTWERPEN',
//     'country' => 'BELGIE',
// ]
```

You can also validate up to 100 addresses at a time. An array of `ValidatedAddresses` will be returned.

```php
$addressValidator = AddressValidator::create();

$validatedAddresses = $addressValidator->validateMany([
    Address::create([
        'streetName' => 'Samberstraat',
        'streetNumber' => '69',
        'boxNumber' => 'D',
        'postalCode' => '2060',
        'municipalityName' => 'Antwaarpe',
        'country' => 'BELGIE',
    ]),
    // ...
]);
```

Address webservice documentation is available on [bpost.be](https://www.bpost.be/site/en/webservice-address).

## Support us

[<img src="https://github-ads.s3.eu-central-1.amazonaws.com/bpost-address-webservice.jpg?t=1" width="419px" />](https://spatie.be/github-ad-click/bpost-address-webservice)

We invest a lot of resources into creating [best in class open source packages](https://spatie.be/open-source). You can support us by [buying one of our paid products](https://spatie.be/open-source/support-us).

We highly appreciate you sending us a postcard from your hometown, mentioning which of our package(s) you are using. You'll find our address on [our contact page](https://spatie.be/about-us). We publish all received postcards on [our virtual postcard wall](https://spatie.be/open-source/postcards).

## Installation

You can install the package via composer:

```bash
composer require spatie/bpost-address-webservice
```

### Testing

``` bash
composer test
```

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

### Security

If you discover any security related issues, please email freek@spatie.be instead of using the issue tracker.

## Postcardware

You're free to use this package, but if it makes it to your production environment we highly appreciate you sending us a postcard from your hometown, mentioning which of our package(s) you are using.

Our address is: Spatie, Kruikstraat 22, 2018 Antwerp, Belgium.

We publish all received postcards [on our company website](https://spatie.be/en/opensource/postcards).

## Credits

- [Sebastian De Deyne](https://github.com/sebastiandedeyne)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
