# MailerLite API v2 PHP SDK

It is an official PHP SDK for MailerLite API v2.

You can find more examples and information about MailerLite API v2 here: [https://developers.mailerlite.com](https://developers.mailerlite.com)

## Getting started

In order to use this library you need to have at least PHP 7.1 version.

There are two ways to use MailerLite PHP SDK:

##### Use [Composer](https://getcomposer.org/)

If you are not familiar with Composer, learn about it [here](https://getcomposer.org/doc/01-basic-usage.md).

Then you will need to run this simple command using CLI:

```
composer require mailerlite/mailerlite-api-v2-php-sdk
```

This library is built atop of [PSR-7](https://www.php-fig.org/psr/psr-7/) and
[PSR-18](https://www.php-fig.org/psr/psr-18/). If you are receiving `Http\Discovery\Exception\DiscoveryFailedException` exception, you will need to run:

```bash
composer require php-http/guzzle6-adapter
```

##### Manual (preferable for shared hostings)

This way is preferable only if you are using shared hosting and do not have a possibility to use Composer. You will need to download [this archive](https://bit.ly/32jmi7M)(v0.2.3), extract it and place its contents in root folder of your project. The next step is the same as using Composer, you will need to require `vendor/autoload.php` file in your index.php and lets dive in!

## Usage examples

#### Groups API

In the given example you will see how to initiate selected API and a few actions which are available:

- Create group
- Get groups
- Update group
- Get subscribers who belongs to selected group

```php
$groupsApi = (new \MailerLiteApi\MailerLite('your-api-key'))->groups();

$newGroup = $groupsApi->create(['name' => 'New group']); // creates group and returns it

$allGroups = $groupsApi->get(); // returns array of groups

$groupId = 123;
$singleGroup = $groupsApi->find($groupId); // returns single item object

$subscribers = $groupsApi->getSubscribers($groupId); // get subscribers who belongs to selected group

$subscribers = $groupsApi->getSubscribers($groupId, 'unsubscribed'); // get unsubscribed subscribers who belongs to selected group
```

#### Use multiple APIs at once

Also `MailerLiteApi\MailerLite' object can be initiated before selecting API you want to use and it allows to achieve more.

```php
$mailerliteClient = new \MailerLiteApi\MailerLite('your-api-key');

$groupsApi = $mailerliteClient->groups();
$groups = $groupsApi->get(); // returns array of groups

$fieldsApi = $mailerliteClient->fields();
$fields = $fieldsApi->get(); // returns array of fields
```

## Use your preferred HTTP client

MailerLite SDK uses cURL as default HTTP client but it is easy to use your preferred client. It is achieved by using [HTTPlug](https://httplug.io) which is PSR-7 compliant HTTP client abstraction.

Here is an example how to use [Guzzle](https://docs.guzzlephp.org/) instead of cURL:

```php
$guzzle = new \GuzzleHttp\Client();
$guzzleClient = new \Http\Adapter\Guzzle6\Client($guzzle);

$mailerliteClient = new \MailerLiteApi\Mailerlite('your-api-key', $guzzleClient);
```

## Support and Feedback

In case you find any bugs, submit an issue directly here in GitHub.

You are welcome to create SDK for any other programming language.

If you have any troubles using our API or SDK free to contact our support by email [info@mailerlite.com](mailto:info@mailerlite)

Official documentation is at [https://developers.mailerlite.com](https://developers.mailerlite.com)
