# Paypal payment integration for laravel framework

    php composer.phar require webzera/payamount
    or
    composer require webzera/payamount

    And php artisan vendor:publish --provider "Webzeral\Payamount\PayamountServiceProvider"

    And paycredentials.php check credentials and url paths    

    In url use /payment ex: 'http://hostname/payment'

    In migration table data's like,
        id 	type_name 	        type_desc 	            status

        1 	Cash On Delivery 	Cash On Delivery 	        0
        2 	Paypal 	            Paypal Payment Gateway 	    1
        3 	CC Avenue 	        CC Avenue Payment Gateway 	1


    or import from databasesource folder    