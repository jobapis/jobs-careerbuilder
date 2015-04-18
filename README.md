# Dice Jobs Client

[![Latest Version](https://img.shields.io/github/release/JobBrander/jobs-dice.svg?style=flat-square)](https://github.com/JobBrander/jobs-dice/releases)
[![Software License](https://img.shields.io/badge/license-APACHE%202.0-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Build Status](https://img.shields.io/travis/JobBrander/jobs-dice/master.svg?style=flat-square&1)](https://travis-ci.org/JobBrander/jobs-dice)
[![Coverage Status](https://img.shields.io/scrutinizer/coverage/g/JobBrander/jobs-dice.svg?style=flat-square)](https://scrutinizer-ci.com/g/JobBrander/jobs-dice/code-structure)
[![Quality Score](https://img.shields.io/scrutinizer/g/JobBrander/jobs-dice.svg?style=flat-square)](https://scrutinizer-ci.com/g/JobBrander/jobs-dice)
[![Total Downloads](https://img.shields.io/packagist/dt/jobbrander/jobs-dice.svg?style=flat-square)](https://packagist.org/packages/jobbrander/jobs-dice)

This package provides Indeed Jobs API support for the JobBrander's [Jobs Client](https://github.com/JobBrander/jobs-common).

## Installation

To install, use composer:

```
composer require jobbrander/jobs-dice
```

## Usage

Usage is the same as Job Branders's Jobs Client, using `\JobBrander\Jobs\Client\Provider\Dice` as the provider.

```php
$client = new JobBrander\Jobs\Client\Provider\Dice();

// Search for 200 job listings for 'project manager' in Chicago, IL
$jobs = $client->setKeyword('project manager')
    ->setCity('Chicago')
    ->setState('IL')
    ->setCount(200)
    ->getJobs();
```

The `getJobs` method will return a [Collection](https://github.com/JobBrander/jobs-common/blob/master/src/Collection.php) of [Job](https://github.com/JobBrander/jobs-common/blob/master/src/Job.php) objects.

## Testing

``` bash
$ ./vendor/bin/phpunit
```

## Contributing

Please see [CONTRIBUTING](https://github.com/jobbrander/jobs-dice/blob/master/CONTRIBUTING.md) for details.


## Credits

- [Karl Hughes](https://github.com/karllhughes)
- [Steven Maguire](https://github.com/stevenmaguire)
- [All Contributors](https://github.com/jobbrander/jobs-dice/contributors)


## License

The Apache 2.0. Please see [License File](https://github.com/jobbrander/jobs-dice/blob/master/LICENSE) for more information.
