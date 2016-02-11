<?php
namespace Sematime;

require __DIR__.'/vendor/autoload.php';
        use Sematime\Api\Sematime;
        
        
        // An Array of recipients
        //$recipients=array('contactId'=>'1', 'name'=>'John Doe','phoneNumber'=>'0727038269');
        // Initialize The Sematime Api

        $sema = new Sematime();
        $contacts = [
        [
            'contactId'=> '1',
            'phoneNumber'=>'1234567890',
            'name' => 'John Doe',
        ],
         [
            'contactId'=> '2',
            'phoneNumber'=>'020345678',
            'name' => 'Arnold Weaver',
        ],
         [
            'contactId'=> '3',
            'phoneNumber'=>'3246789009',
            'name' => 'Mary Cook',
        ],
         [
            'contactId'=> '4',
            'phoneNumber'=>'0345789032',
            'name' => 'Garry DAvis',
        ],

    ];
    $group= 'My List';
        $sema = new Sematime();
        $list = $sema->addGroup($group)->addContacts($contacts)->save(); // sure enough all your contacts will be saved
        echo json_encode($list->contacts);


        /*$message='nice one a message send through the awesome sematime api';
            $results = $gateway->sendMessage($recipients, $message);
            isset($results) ? $response = $results : $response = 'An Error Was Encoutered';
            
            echo $response ;
        
        $dotenv = new Dotenv(__DIR__);
        $dotenv->load();
        echo getenv('API_KEY');
        var_dump($dotenv);
        ?>*/
