<?php

Route::group(['namespace' => 'Botble\Frame\Http\Controllers', 'middleware' => ['web', 'core']], function () {

    Route::group(['prefix' => config('core.base.general.admin_dir'), 'middleware' => 'auth'], function () {

        Route::group(['prefix' => 'frames', 'as' => 'frame.'], function () {

            Route::resource('', 'FrameController')->parameters(['' => 'frame']);

            Route::delete('items/destroy', [
                'as'         => 'deletes',
                'uses'       => 'FrameController@deletes',
                'permission' => 'frame.destroy',
            ]);
        });
    });

});
