# laravel Exceptions to Mail

![Laravel 5.5](https://img.shields.io/badge/Laravel-5.5-f4645f.svg)
![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)

This package will allow you to specify mail addresses to send them all the exceptions of your application.

## Installation

You can install the package via composer:
``` bash
$ composer require fahedaljghine/laravel-exceptions-to-mail
```

The package will automatically register itself.

You can publish the config file with:
```bash
php artisan vendor:publish --provider="fahedaljghine\ErrorsMail\ErrorsMailServiceProvider"
```

This is the contents of the published config file:

```php
// config/errors-mail.php

return [
	/*
     * Add email address you want exceptions to be sent
	 * Please don't set my email address !!!
     */
    'mails' => [
        //'fahedaljghine2014@gmail.com',
    ],
];
```

## To Do

1- add exceptions profile to allow sending the emails only for group of exceptions.


## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

