<?php
namespace Sematime;

require __DIR__.'/vendor/autoload.php';
        use Sematime\Api\Sematime;
        
        
        // An Array of recipients
        //$recipients=array('contactId'=>'1', 'name'=>'John Doe','phoneNumber'=>'0727038269');
        // Initialize The Sematime Api

        $sema = new Sematime();
        $sema->addContact()


        /*$message='nice one a message send through the awesome sematime api';
            $results = $gateway->sendMessage($recipients, $message);
            isset($results) ? $response = $results : $response = 'An Error Was Encoutered';
            
            echo $response ;
        
        $dotenv = new Dotenv(__DIR__);
        $dotenv->load();
        echo getenv('API_KEY');
        var_dump($dotenv);
        ?>*/
