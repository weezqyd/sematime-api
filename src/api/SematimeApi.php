<?php
namespace Sematime\Api;
/**
 * SendSMS With SemaTime API
 * 
 * @package V 1.0 Alpha  
 * @author  The Weezqyd
 *          wizqydy@gmail.com   
 * @copyright Weeztech Inc
 * @version 2015
 * @access public
 *
 **/
/*
 *  Copyright (c) 2015, Weeztech Inc. 
        All rights reserved.

        */
    use Sematime\Api\Exception\SematimeAPIException;
    use Sematime\Contracts\SematimeContract as Contract;
    use Sematime\Api\CurlHandler as Curl;
    use Sematime\Api\Sematime;

class SematimeAPI extends Curl implements Contract
{
   
    function __construct()
    {   
        parent::__construct();
        //$this->curl= new Curl();
        $this->_requestBody = null;
        $this->_requestUrl = null;

        $this->_responseBody = null;
        $this->_responseInfo = null;

    }
     function sendMessage($to_, $message_, array $options_ = array())
    {
        if (count($to_) ==0 || strlen($message_) == 0)
        {
            echo SematimeAPIException::toOrMessage();
        }
        $params = [
            'message' => $message_,
            'recipients' => implode(',',$to_),
            ];
        $this->_requestUrl = str_replace('{userId}', $this->_userid, $this->SMS_URL);
        $this->_requestBody = json_encode($params);

        $con=$this->curlInitialize();
        $response = json_decode($this->_responseBody);
        //var_dump($con);
        if(is_object($response))
        {
               if($response->statusCode == $this->CREATED)
                {
                $responseObject = json_decode($this->_responseBody);
                return $responseObject->SMSMessageData->Recipients;

                }
                //var_dump($this);
                print $response->description;
                exit;
        }
        else
        {
            print SematimeAPIException::noConnection();
            exit;         
        }

        
    }
}
