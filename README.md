
# Sematime Api gateway for php 

[![Build Status](https://secure.travis-ci.org/nategood/httpful.png?branch=master)](http://travis-ci.org/nategood/httpful) 
[![Latest Stable Version](https://poser.pugx.org/weezqydy/sematimeapi/v/stable)](https://packagist.org/packages/weezqydy/sematimeapi) [![Total Downloads](https://poser.pugx.org/weezqydy/sematimeapi/downloads)](https://packagist.org/packages/weezqydy/sematimeapi) [![Latest Unstable Version](https://poser.pugx.org/weezqydy/sematimeapi/v/unstable)](https://packagist.org/packages/weezqydy/sematimeapi) [![License](https://poser.pugx.org/weezqydy/sematimeapi/license)](https://packagist.org/packages/weezqydy/sematimeapi)

This is a php package that you can easily intergarate into your project to send SMS Messages using the awesome Sematime API, to start using this package require it in your project using composer a php Dependency management tool.
if you dont have composer installed head over to [Composer](http://getcomposer.org/download) and install

To include this package in your project add this to your composer.json and then run composer update
```
	{
        "require": {
            "weezqydy/sematimeapi": "*"
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

- To interact with sematime API, you will need to have an API key and the user ID of your Sematime account. We use these credentials to authenticate your requests.
- Login to your Sematime account and then click on the ‘My Account’ drop-down menu on your top right corner, choose ‘API Integration’ and then click on the ‘Generate Key’. You will be assigned a 32 character long API Key plus the accompanying user ID.

### Getting Started
- Now at the root of yor project create a new file and name it .env 
- In the file you just created add your API key and User Id as follows
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
 You can optionally add other parameterss while building your message

 - salutation() – an optional parameter whose value is the salutation type to use.
When provided, each recipient will receive a personalized message beginning
with the salutation followed by their name. For example: Dear Admin, Dear
Lucy, Dear Jean etc in which case the salutation is the word ‘Dear
```php
     //you can chain the parameters in any order
    $sema->message('message to send')->addTo('1234567890')->salutation('Dear')->send();
```
- signature() - an optional parameter whose value is a unique message that is
attached at the end of all the messages that you send. For example, Sent by The
Sematime team. Call 0706129100 .

- scheduledTime() – an optional parameter whose value is the date and time in
milliseconds when you want the message to be sent out on a future date.

- senderId() – an optional parameter whose value is the sender ID / brand that
will be used to send your message. If not specified, your Sematime
account’s sender Id will be used instead.

- extra() – an optional parameter containing additional parameters that
you may need to pass on to our API for later processing by your system. For
example, account numbers, user Ids, etc. We don’t process these parameters and
will pass them to you when invoking your callback.

```php
    $sema->signature('Sent by The Sematime team. Call 0706129100');// other parameters folows
```
 We can also add contacts to your sematime account
 ```php
    require __DIR__.'/vendor/autoload.php';
        use Sematime\Api\Sematime;      
        // Initialize The Sematime Api
        $sema = new Sematime();
        $response=$sema->addGroup('members') // the group name you wish to add contacts
                       ->addId('1') // contact id for the contact you want to add
                       ->addName('John Doe') // a name for your contact 
                       ->addPhone('1234567890') // phone number you wish to add
                       ->save(); // finally save your contact
          print  $response; // {"statusCode":200, "description":"Contacts added successfully.", "totalContacts":1, "contactsAdded":1}
 ```
 
