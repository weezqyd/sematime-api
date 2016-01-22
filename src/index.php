<?php
namespace Sematime;

require __DIR__.'/../vendor/autoload.php';
        use Sematime\Api\SematimeAPI;
        use Sematime\Api\SematimeAPIException;
        // An Array of recipients
        $recipients[] = '123456789';
        // Initialize The Sematime Api
        $gateway = new SematimeAPI();
        $message='nice one';
        try
        {
            $results = $gateway->sendMessage($recipients, $message);
            echo $results;
            //echo "string";
        }
        catch (SematimeAPIException $e)
        {
            $response = json_decode($e->getMessage());
                if($response->statusCode ==$gateway->UNAUTHORIZED){
                    echo $response->description;
                }
                else
                {
                    echo $response->description;
                }
            
        }
        //var_dump($gateway);
        ?>
