<?php
$namespace = 'Webzera\Payamount\Http\Controllers';

Route::group([
    'namespace' => $namespace,
    'prefix' => 'payment',
], function(){
    // Route::get('/', function(){ return ['hey', 'John']; });
    
    Route::get('/', 'PaymentController@index')->name('pay');
    Route::Post('create', 'PaymentController@create')->name('create-payment');
    Route::get('excute', 'PaymentController@excute')->name('excute-payment');
    Route::get('cancel', 'PaymentController@cancel')->name('cancel-payment');
});