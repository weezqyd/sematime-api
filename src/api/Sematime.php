<?php
namespace Sematime\Api;

use Sematime\Api\Exception\SematimeAPIException;
use Sematime\Api\HttpClient;
/**
* 
*/
class Sematime extends HttpClient
{
	
	public $_apiKey ;
    public $_userid ;
    public $_requestBody;
    public $_requestUrl;
    public $_responseBody = array();
    public $_responseInfo;
    public $_to = array();
    public $_from;
    public $contact = array();
    public $contacts = array();
    public $SMS_URL = "https://api.sematime.com/v1/{userId}/messages";
    public $URL = "https://api.sematime.com/v1/{userId}";

    public $OK = 200;
    public $CREATED = 201;
    public $UNAUTHORIZED =401;
    public $FORBIDDEN =403;
    public $BAD_REQUEST =400;
    public $NOT_FOUND =404;
    public $SERVER_ERROR =500;


    const Debug = false;
    function __construct()
    {
    	parent::__construct();
        $this->url=str_replace('{userId}', $this->_userid, $this->URL);
    }
   
    public function addTo($to = array())
        {
          if(is_array($to)){
           foreach ($to as $key => $reccipient)
            {
                 $this->_to[$key]= $reccipient;   
            }
        $this->_responseBody['recipients'] = implode(',',$this->_to);
            } else{ throw new SematimeAPIException('AddTo Expexts the recipients to be an array');}
        return $this;
        }
    public function senderId($from ='')
        {
            $this->_responseBody['senderId'] = $from;
            return $this;
        }
    public function addId($cid='',$id = 0 )
        { 
           $this->contacts[$id]['contactId'] = $cid;
           return $this; 
        }
    public function addName($name='',$id = 0 )
        { 
        if($name==''){print SematimeAPIException::contactRequired();exit;}
           $this->contacts[$id]['name'] = $name;
           return $this; 
        }
    public function addPhone($phone='',$id = 0 )
        {
        if($phone==''){print SematimeAPIException::contactRequired();exit;}
           $this->contacts[$id]['phoneNumber'] = $phone; 
           return $this;
        }
    public function save()
        {
            $this->contact['contacts']=$this->contacts;
            $this->_requestUrl=$this->url.'/contacts';
            //return $this;
            return $this->exec($this->_requestUrl,$this->contact);
        }
    public function addGroup($group='')
        {
        if($group==''){print 'a group name is reuired'; exit;}
           $this->contact['groupName'] = $group;
           return $this; 
        }
        /**
        *@param $masage
        */
        //message – the message to send.
    public function message($message)
        {
            if(empty($message)){print SematimeAPIException::toOrMessage(); exit; }
            $this->_responseBody['message'] = $message;
            $this->_requestUrl = str_replace('{userId}', $this->_userid, $this->SMS_URL);
            return $this;
        }
    public function scheduledTime($time = '')
        {
            $time==='' ? $time=time() : $time;
            $this->_responseBody['scheduledTime'] = $time;
            return $this;
        }
    public function callbackUrl($url)
        {
            if(filter_var($url, FILTER_VALIDATE_URL)==false){ print SematimeAPIException::invalidUrl(); exit;}
            $this->_responseBody['callbackUrl'] = $url;
            return $this;
        }
    public function signature($signature)
        {
           $this->_responseBody['signature'] = $signature;
           return $this;
        }
    public function salutation($salutation)
        {
            $this->_responseBody['salutation']= $salutation;
            return $this;
        }
    public function extra($extra)
        {
           $this->_responseBody['extraParameters']=$extra;
           return $this;
        }
    public function getScheduled($messageId)
        {
            $this->_requestUrl=$this->url.'/messages/scheduled/'.$messageId;
            return $this->get();
        }
    public function getAllScheduled($limit= -1, $offset=  0)
    {
        $this->_responseBody['rowCount']=$limit;
        $this->_responseBody['lastOffset'] = $offset;
        $this->_requestUrl=$this->url.'/messages/scheduled';
        return $this->get($this->_requestUrl,$this->_responseBody);
    }
    public function deleteScheduled($messageId)
    {
        $this->_requestUrl=$this->url.'/messages/scheduled/'.$messageId.'/delete';
        $this->post($this->_requestUrl);
    }
    public function send()
    {
        return $this->exec($this->_requestUrl,$this->_responseBody);
    }
    public function getGroupContacts($group, $limit=20, $offset=0)
    {
        $this->_responseBody['groupName'] = $group;
        $this->_responseBody['rowCount'] = $limit;
        $this->_responseBody['lastOffset'] = $offset;
        $this->_requestUrl = $this->url.'/contacts?'.http_build_query($this->_responseBody, '', '&');
        //return json_encode($this->_responseBody);
        return $this->get($this->_requestUrl);
    }
    public function addContacts($contacts)
    {
      if(array_key_exists('name', $contacts) AND array_key_exists('contactId', $contacts) AND array_key_exists('phoneNumber', $contacts)){
      }
      else{
        throw new SematimeAPIException("Your contacts dont seem to be prepared correctly");
      }
        return $this;

    }
    public function editContact($contactId, $params=[])
    {
        if(array_key_exists('groupName', $params)){
        foreach ($params as $key => $contact) 
        {
            if($key==='newName' OR $key==='newPhoneNumber' OR $key==='groupName'){
            $this->contacts[$key]=$contact;
            }
            else{throw new SematimeAPIException('Please provide all the details for editing the contact'); }
        }
        }
        else{throw new SematimeAPIException('A group name is required to edit contacts'); }
        $this->_requestUrl=$this->url.'/contacts/'.$contactId;
        $this->_responseBody=$this->contacts;
        return $this->put($this->_requestUrl,$this->_responseBody);
    }
    public function getContact($id = '', $group='')
    {
        if($id=='' OR $group==''){
            throw new SematimeAPIException('Specify A Contactid Or Group You want to get');
        }
        $this->_responseBody['groupName'] = $group;
        $this->_requestUrl = $this->url.'/contacts/'.$id.'?'.http_build_query($this->_responseBody, '', '&');
        return $this->get($this->_requestUrl);
        
    }
    
}
