<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services author: John
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Stripe, Mailgun, SparkPost and others. This file provides a sane
    | default location for this type of information, allowing packages
    | to have a conventional place to find your various credentials.
    |
    */    

    'paypal' => [
        'id' => env('PAYPAL_ID'),
        'secret' => env('PAYPAL_SECRET'),
        'ret-success' => 'http://yourhostname/payment/excute',
        'ret-cancel' => 'http://yourhostname/payment/cancel',
    ],

];
