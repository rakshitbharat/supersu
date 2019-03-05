A Laravel 5.5 utility package to enable developers to log in as other users during development.


## Installation

To install the package, simply follow the steps below.

Install the package using Composer:

```
$ composer require rakshitbharat/supersu
```

⚠️  *Warning:* You should not register the provider globally like usual in the `config/app.php` file. View the disclaimer [here](#disclaimer---danger) for more information.

Include the partial in your layout file.

```php
@if (config('app.debug'))
    @include('supersu::user-selector')
@endif
```

Finally, publish the package's assets (the package won't work without this):

```
$ php artisan vendor:publish
```

## Config:
After running `vendor:publish`, a config file called `supersu.php` should appear in your project. Within here, there are two configuration values.

**sudosu.user_model `string`**
```
The path to the application User model. This will be used to retrieve the users displayed in the select dropdown. This must be an Eloquent Model instance. This is set to `App\User` by default.
```

## Events:
Below is events called before and after switching of user. You can replicate of below file to extend your logic. 

```php
<?php

namespace App\Facades;

class SupersuCustom {

    public static function loginAsUser($object = null) {

    }

    public static function returnCurrent($object = null) {

    }

}
```

## Disclaimer - Alert!
This package can pose a serious security issue if used incorrectly, as anybody will be able to take control of any user's account. Please ensure that the service provider is only registered when the app is in a debug/local environment.

By using this package, you agree that Rakshit Patel and the contributors of this package cannot be held responsible for any damages caused by using this package.
