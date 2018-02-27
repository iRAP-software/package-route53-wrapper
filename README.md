Route 53 Wrapper
=================

This is a package to make it much easier to work with the Route53 service.

The AWS documentation for the raw requests this wraps around:
* [Route53](https://docs.aws.amazon.com/aws-sdk-php/v3/api/namespace-Aws.Route53.html)
* [Route53Domains](https://docs.aws.amazon.com/aws-sdk-php/v3/api/namespace-Aws.Route53Domains.html)

## Installation
```
composer require irap/route53-wrapper
```

## Example Usage

```php

# include packagist's autoloader
require_once(__DIR__ . '/vendor/autoload.php');


# Create the route53 client for interfacing with route53
$region = \iRAP\Route53Wrapper\Objects\AwsRegion::create_EU_W1();
$route53Client = new \iRAP\Route53Wrapper\Route53Client('myAwsKey', 'myAwsSecretKey', $region);

# Get our zones...
$hostedZones = $route53Client->getHostedZones();
```




