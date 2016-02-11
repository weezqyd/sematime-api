<?php
namespace Sematime;

require __DIR__.'/vendor/autoload.php';
        use Sematime\Api\Sematime;
        
        
        // An Array of recipients
        //$recipients=array('contactId'=>'1', 'name'=>'John Doe','phoneNumber'=>'0727038269');
        // Initialize The Sematime Api

        $sema = new Sematime();
        $response= $sema->signature('Sent by The Sematime team. Call 0706129100')
        ->salutation('Dear')
         //->senderId('Sematime')
         //->scheduledTime('1466683660000')
         //->callbackUrl('https://api.mydomain.com/callback')
         //->extra('extra=extra data')
         ->addTo(['0729422001'])
         ->message('an awesome message')
         ->send(); // send the message//$sema->getContacts('Testing');
        //print json_encode($response->contact);
        //print json_encode($sema->contact);
        echo $response;


        /*$message='nice one a message send through the awesome sematime api';
            $results = $gateway->sendMessage($recipients, $message);
            isset($results) ? $response = $results : $response = 'An Error Was Encoutered';
            
            echo $response ;
        
        $dotenv = new Dotenv(__DIR__);
        $dotenv->load();
        echo getenv('API_KEY');
        var_dump($dotenv);
        ?>*/
