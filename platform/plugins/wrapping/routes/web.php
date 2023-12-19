<?php

Route::group(['namespace' => 'Botble\Wrapping\Http\Controllers', 'middleware' => ['web', 'core']], function () {

    Route::group(['prefix' => config('core.base.general.admin_dir'), 'middleware' => 'auth'], function () {

        Route::group(['prefix' => 'wrappings', 'as' => 'wrapping.'], function () {

            Route::resource('', 'WrappingController')->parameters(['' => 'wrapping']);

            Route::delete('items/destroy', [
                'as'         => 'deletes',
                'uses'       => 'WrappingController@deletes',
                'permission' => 'wrapping.destroy',
            ]);
        });
    });

});
