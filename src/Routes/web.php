<?php

Route::group([
    'prefix' => 'supersu',
    'namespace' => 'Rakshitbharat\Supersu\Controllers',
    'middleware' => Config::get('supersu.user_middleware')
        ], function () {
    Route::any('/supersu/login-as-user', 'SupersuController@loginAsUser')
            ->name('supersu.login_as_user');

    Route::any('/supersu/return', 'SupersuController@returnCurrent')
            ->name('supersu.return');
});
