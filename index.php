<?php
namespace Sematime;

require __DIR__.'/vendor/autoload.php';
        use Sematime\Api\SematimeAPI;
        use Sematime\Api\SematimeAPIException;
        
        
        // An Array of recipients
        $recipients[] = '1234567890';
        // Initialize The Sematime Api
        $gateway = new SematimeAPI();
        $message='nice one a message send through the awesome sematime api';
            $results = $gateway->sendMessage($recipients, $message);
            echo $results;
            //echo "string";
        /*
        $dotenv = new Dotenv(__DIR__);
        $dotenv->load();
        echo getenv('API_KEY');
        var_dump($dotenv);
        ?>*/
