
# Sematime Api gateway for php 

[![Build Status](https://travis-ci.org/weezqyd/sematime-api.svg?branch=master)](http://travis-ci.org/weezqydy/sematimeapi) 
[![Latest Stable Version](https://poser.pugx.org/weezqydy/sematimeapi/v/stable)](https://packagist.org/packages/weezqydy/sematimeapi) [![Total Downloads](https://poser.pugx.org/weezqydy/sematimeapi/downloads)](https://packagist.org/packages/weezqydy/sematimeapi) [![Latest Unstable Version](https://poser.pugx.org/weezqydy/sematimeapi/v/unstable)](https://packagist.org/packages/weezqydy/sematimeapi) [![License](https://poser.pugx.org/weezqydy/sematimeapi/license)](https://packagist.org/packages/weezqydy/sematimeapi)

This is a php package that you can easily intergarate into your project to send SMS Messages using the awesome Sematime API, to start using this package require it in your project using composer a php Dependency management tool.
if you dont have composer installed head over to [Composer](http://getcomposer.org/download) and install

To include this package in your project add this to your composer.json and then run composer update
```
    {
        "require": {
            "weezqydy/sematimeapi": "^1.0"
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
Sematime account already, go to [Sematime](http://sematime.elasticbeanstalk.com/register) and get
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

### Messages
#### Sending Messages

With everything configured properly, we are now ready to send our first message using sematime
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
    $sema->message('message to send')->addTo(['1234567890'])->salutation('Dear')->send();
```
- signature() - an optional parameter whose value is a unique message that is
attached at the end of all the messages that you send. For example, Sent by The
Sematime team. Call 0706129100 .

- scheduledTime() – an optional parameter whose value is the date and time in
milliseconds when you want the message to be sent out on a future date.

- senderId() – an optional parameter whose value is the sender ID / brand that
will be used to send your message. If not specified, your Sematime
account’s sender Id will be used instead.

- callbackUrl() – an optional parameter whose value is the URL that we will call in
order to pass the delivery report after sending a scheduled message. All callbacks
are invoked via HTTP POST.

- extra() – an optional parameter containing additional parameters that
you may need to pass on to our API for later processing by your system. For
example, account numbers, user Ids, etc. We don’t process these parameters and
will pass them to you when invoking your callback.

```php
  // all these methods are chainable
    $sema->signature('Sent by The Sematime team. Call 0706129100')
         ->senderId('Sematime') // Use this option only if you have an existing  ID
         ->scheduledTime('1466683660000') // Must be a future timestamp
         ->callbackUrl('https://api.mydomain.com/callback') // must be an existing and Valid URL
         ->extra('extra=extra data') // Only accepts strings 
         ->addTo(array('1234567890')) // addTo expects an array of recipients
         ->message('an awesome message')
         ->send(); // send the message
```
#### Geting Scheduled Messages
To retreive Scheduled messages  
```php
    $sema = new Sematime\Api\Sematime();
    $scheduled= $sema->getAllScheduled(); // returns the first 20 scheduled messages

    /* retrieve more scheduled messages or retrieve from a certain point.*/
    $startFrom = 15;
    $fetch=40;
    // retrieves 40 messages starting form the 15th
     $scheduled= $sema->getAllScheduled($fetch, $startFrom);
     print $scheduled;

```
### Contacts
Sematime organizes contacts into groups. A group will usually contain the contacts of people
who share some relationship. For example, group ‘Sales Team’ would be a group for the
members of the company’s sales team.
#### Adding Contacts
 We can also add contacts to your sematime account, just prepare your contact and then save it
 ```php
    require __DIR__.'/vendor/autoload.php';
        use Sematime\Api\Sematime;      
        // Initialize The Sematime Api
        $sema = new Sematime();
        $response=$sema->groupName('My Group') // the group name you wish to add contacts
                       ->addId('1') // contact id for the contact you want to add
                       ->addName('John Doe') // a name for your contact 
                       ->addPhone('1234567890') // phone number you wish to add
                       ->save(); // finally save your contact
          print  $response; // {"statusCode":200, "description":"Contacts added successfully.","totalContacts":1, "contactsAdded":1}
 ```


#### Retreiving Contacts

- Getting contacts from a group - Provide the group name for the contacts you want to retreive


```php
    use Sematime/Api/Sematime;

    $sema= new Sematime();
    $group = 'My Group'; // The group you want to get contacts;
    $contacts= $sema->getGroupContacts($group); // you will get a json formated string of your contacts

```
- Getting an Individual contact from a group - Pass in the contactId as the first parameter followed by the groupName

```php
    use Sematime/Api/Sematime;

    $sema= new Sematime();
    $group = 'My Group'; // The group you want to get contacts;
    $contactId= '14578652';
    $contacts= $sema->getContacts($contactId, $group); // you will get a json formated string of the contact

```
#### Editing Contacts
To edit your contact all you need to do is provide your new name or new phone number for that contact

````php
    use Semamatime/Api/Sematime;

    $sema= new Sematime();

    $contactId = '145367'; // provide the contact id to edit this required
    $groupName = 'My Group'; // The group in which the contact exists this is required
    $newName = 'David Clerk'; // New name for contact optional
    $newPhoneNumber = '1234567890';  // New phone Number to the contact, optional

    $response= $sema->editContact($constactId, $group, $newName, $newPhoneNumber);
     echo $response; // Contact updated successfully.
            

```
#### Deleting Contacts
Deleting a contact only requires you to provide the group and ID of the contact you wish to delete

```php
 use Semamatime/Api/Sematime;

    $sema= new Sematime();

    $contactId = '145367'; // provide the contact id to edit this required
    $groupName = 'My Group'; // The group in which the contact exists this is required

    $response = $sema->deleteContact($contactId, $group);
    echo $response; // Contact Deleted successfully
```
#### Account details
To retrieve your account details 
```php 
use Semamatime/Api/Sematime;

    $sema= new Sematime();

    $response = $sema->accountDetails();

    echo $response //{"account":{"accountId":"xxxxxxxxxxxxx", "name":"Your Name", "phoneNumber":"123456789", "smsBalance":0, "accountType":"school", "senderId":"Sematime", "paymentPlan":"prepaid", "createdOn":"Wed, 09\/09\/2015 04:59 PM"}, "statusCode":200, "description":"Account profile retrieved successfully."}