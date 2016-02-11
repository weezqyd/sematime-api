# Sematime Api gateway for php 
This is a php package that you can easily intergarate into your project to send SMS Messages using the awesome Sematime API, to start using this package require it in your project using composer a php Dependency management tool.
if you dont have composer installed head over to [Composer](http://getcomposer.org/download) and install

To include this package in your project add this to your composer.json and then run composer update
```
	{
        "require": {
            "weezqydy/sematimeapi": "dev-master"
        }
    }
```
### Introduction
The Sematime API makes it possible for you to send branded and personalized SMS messages
from your php application. In addition, the API also exposes contacts management functions that let
you can store, edit or delete contacts on behalf of your users.

Before you get started with the API, we will need you to do the following:
### Creating a free Sematime account
A Sematime account is needed before you can start using our API. If you do not have a
Sematime account already, go to [Sematime](https://myaccount.sematime.com/regiser) and get
yourself an account.

#### Getting your API credentials

- To interact with our API, you will need to have an API key and the user ID of your Sematime account. We use these credentials to authenticate your requests.
- Login to your Sematime account and then click on the ‘My Account’ drop-down menu on your top right corner, choose ‘API Integration’ and then click on the ‘Generate Key’. You will be assigned a 32 character long API Key plus the accompanying user ID.

### Getting Started
- Now at the root of yor project create a new file and name it .env 
- In the file you just created add your API key and User Id
```
API_KEY = "your-sematime-api-key"
USER_ID = "user-id-from-sematime"
```
We are now ready to send our first message using sematime
```php
// Include the composer autoloader if its not included yet
require __DIR__.'/vendor/autoload.php';
        use Sematime\Api\Sematime;
        // An Array of recipients
        $recipients = ['1234567890','0987654321','6789054321'];
        // Initialize The Sematime Api
        $gateway = new Sematime();
        //Create Your Message
        $message='A nice message send using Sematime';
       
        $results = $gateway->AddTo($recipients)->message($message)->send();
        // if evrything goes well you will get a response from Sematime
        echo $results;
        
 ```
 
