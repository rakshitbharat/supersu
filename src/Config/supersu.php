<?php

return [
    /*
      |--------------------------------------------------------------------------
      | User Model
      |--------------------------------------------------------------------------
      |
      | Path to the application User model. This will be used to retrieve the users
      | displayed in the select dropdown. This must be an Eloquent Model instance.
      |
     */
    'user_model' => App\Admin::class,
    'user_middleware' => ['web', 'admin', 'auth:admin'],
];
