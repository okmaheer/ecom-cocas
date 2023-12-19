<?php

Route::group(['namespace' => 'Botble\Material\Http\Controllers', 'middleware' => ['web', 'core']], function () {

    Route::group(['prefix' => config('core.base.general.admin_dir'), 'middleware' => 'auth'], function () {

        Route::group(['prefix' => 'materials', 'as' => 'material.'], function () {

            Route::resource('', 'MaterialController')->parameters(['' => 'material']);

            Route::delete('items/destroy', [
                'as'         => 'deletes',
                'uses'       => 'MaterialController@deletes',
                'permission' => 'material.destroy',
            ]);
        });
    });

});
