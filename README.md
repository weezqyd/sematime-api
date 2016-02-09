# sematime-api
Sematime Api gateway for php
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
        try
        {
            $results = $gateway->sendMessage($recipients, $message);
            echo $results;
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
 ```
 
