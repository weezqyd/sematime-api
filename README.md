# Sematime Api gateway for php 
This is a php package that you can easily intergarate into your project to send SMS Messages usint the awesome Sematime API, to start using this package require it in your project
 ```
 composer require weezqydy/sematimeapi dev-master
 ```
Send a message
```php
require __DIR__.'/../vendor/autoload.php';
        use Sematime\Api\SematimeAPI;
        use Sematime\Api\SematimeAPIException;
        // An Array of recipients
        $recipients[] = '123456789';
        // Initialize The Sematime Api
        $gateway = new SematimeAPI();
        $message='A nice message send using Sematime';
       
        $results = $gateway->sendMessage($recipients, $message);
        echo $results;
        
 ```
 
