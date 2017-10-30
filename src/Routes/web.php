<?php

Route::group([
    'prefix' => 'supersu',
    'namespace' => 'Rakshitbharat\Supersu\Controllers',
    'middleware' => Config::get('supersu.user_middleware')
        ], function () {
    Route::get('/supersu/login-as-user', 'SupersuController@loginAsUser')
            ->name('supersu.login_as_user');

    Route::post('/supersu/return', 'SupersuController@return')
            ->name('supersu.return');
});
