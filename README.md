# Careerbuilder Jobs Client

[![Latest Version](https://img.shields.io/github/release/jobapis/jobs-careerbuilder.svg?style=flat-square)](https://github.com/jobapis/jobs-careerbuilder/releases)
[![Software License](https://img.shields.io/badge/license-APACHE%202.0-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Build Status](https://img.shields.io/travis/jobapis/jobs-careerbuilder/master.svg?style=flat-square&1)](https://travis-ci.org/jobapis/jobs-careerbuilder)
[![Coverage Status](https://img.shields.io/scrutinizer/coverage/g/jobapis/jobs-careerbuilder.svg?style=flat-square)](https://scrutinizer-ci.com/g/jobapis/jobs-careerbuilder/code-structure)
[![Quality Score](https://img.shields.io/scrutinizer/g/jobapis/jobs-careerbuilder.svg?style=flat-square)](https://scrutinizer-ci.com/g/jobapis/jobs-careerbuilder)
[![Total Downloads](https://img.shields.io/packagist/dt/jobapis/jobs-careerbuilder.svg?style=flat-square)](https://packagist.org/packages/jobapis/jobs-careerbuilder)

This package provides [Careerbuilder Job Search API ](http://api.careerbuilder.com/Search/jobsearch/jobsearchinfo.aspx)
support for [Jobs Common](https://github.com/jobapis/jobs-common).

## Installation

To install, use composer:

```
composer require jobapis/jobs-careerbuilder
```

## Usage

Create a Query object and add all the parameters you'd like via the constructor.
 
```php
// Add parameters to the query via the constructor
$query = new JobApis\Jobs\Client\Queries\CareerbuilderQuery([
    'DeveloperKey' => YOUR_API_ID
]);
```

Or via the "set" method. All of the parameters documented in Indeed's documentation can be added.

```php
// Add parameters via the set() method
$query->set('Keywords', 'engineering');
```

You can even chain them if you'd like.

```php
// Add parameters via the set() method
$query->set('FacetCity', 'Chicago')
    ->set('FacetState', 'IL');
```
 
Then inject the query object into the provider.

```php
// Instantiating provider with a query object
$client = new JobApis\Jobs\Client\Provider\CareerbuilderProvider($query);
```

And call the "getJobs" method to retrieve results.

```php
// Get a Collection of Jobs
$jobs = $client->getJobs();
```

This will return a [Collection](https://github.com/jobapis/jobs-common/blob/master/src/Collection.php) of [Job](https://github.com/jobapis/jobs-common/blob/master/src/Job.php) objects.

## Testing

``` bash
$ ./vendor/bin/phpunit
```

## Contributing

Please see [CONTRIBUTING](https://github.com/jobapis/jobs-careerbuilder/blob/master/CONTRIBUTING.md) for details.

## Credits

- [Karl Hughes](https://github.com/karllhughes)
- [Steven Maguire](https://github.com/stevenmaguire)
- [All Contributors](https://github.com/jobapis/jobs-careerbuilder/contributors)

## License

The Apache 2.0. Please see [License File](https://github.com/jobapis/jobs-careerbuilder/blob/master/LICENSE) for more information.
