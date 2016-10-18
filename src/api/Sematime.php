<?php
namespace Sematime\Api;

use Sematime\Api\Exception\SematimeAPIException;
use Sematime\Api\HttpClient;
/**
* 
*/
class Sematime extends HttpClient
{
	

    protected $_to = array();
    protected $_from;
    protected $contact = array();
    protected $contacts = array();
    protected $SMS_URL = "https://api.sematime.com/v1/{userId}/messages";
    protected $URL = "https://api.sematime.com/v1/{userId}";

    protected $OK = 200;
    protected $CREATED = 201;
    protected $UNAUTHORIZED =401;
    protected $FORBIDDEN =403;
    protected $BAD_REQUEST =400;
    protected $NOT_FOUND =404;
    protected $SERVER_ERROR =500;


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
    public function addId($cid='',$id=0)
        { 
           $this->contacts[$id]['contactId'] = $cid;
           return $this; 
        }
    public function addName($name='',$id = 0)
        { 
        if($name==''){print SematimeAPIException::contactRequired();exit;}
           $this->contacts[$id]['name'] = $name;
           return $this; 
        }
    public function addPhone($phone='', $id = 0)
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
    public function groupName($group='')
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
            if(filter_var($url, FILTER_VALIDATE_URL)==false)
                throw new SematimeAPIException('please provide a valid URL');
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
    public function editContact($id, $group, $name = null, $phone = null)
    {
        $this->contact['groupName'] = $group;
        if($name !== NULL)
            $this->contact['newName'] = $name;
        if($phone !== NULL)
            $this->contact['newPhoneNumber'] = $phone;
        $this->_requestUrl=$this->url.'/contacts/edit/'.$id;
        //return json_encode($this->contact);
        return $this->exec($this->_requestUrl,$this->contact);
    }

    public function deleteContact($id, $group)
    {
        $this->contact['groupName'] = $group;
        $this->_requestUrl=$this->url.'/contacts/delete/'.$id;
        return $this->exec($this->_requestUrl,$this->contact);
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
    public function newName($name= '')
    {
       if(!isset($name)){
       throw new SematimeAPIException('Please provide a name for your contact'); 
        }
        $this->contact['newname'] = $name;
        return $this;
    }
    public function newPhoneNumber($phone='')
    {
       if(empty($phone)){
       throw new SematimeAPIException('Please provide a phone numberfor your contact'); 
        }
        $this->contact['newPhoneNumber'] = $phone;
        return $this;
    }

    public function accountDetails()
    {
        $this->_requestUrl=$this->url.'/accounts';
        return $this->get($this->_requestUrl);
    }
    // public function renameGroup($group, $new_name)
    // {

    //     $this->_requestUrl=$this->url.'/groups/rename/'.$group;
    //     return $this->exec($this->_requestUrl, ['newName' => $new_name]);
    // }
    // public function groups()
    // {
    //    return $this->get($this->url.'/contacts/groups');
    // }
}
