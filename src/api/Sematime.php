<?php
namespace Sematime\Api;

use Sematime\Api\Exception\SematimeAPIException;
/**
* 
*/
class Sematime
{
	
	public $_apiKey = 'fe07378b95dd4cee8ab78f88d1fa2a34';
    public $_userid = '1441807142147';
    public $_requestBody;
    public $_requestUrl;
    public $_responseBody;
    public $_responseInfo;

    public $SMS_URL = "https://api.sematime.com/v1/{userId}/messages";
    public $URL = "https://api.sematime.com/v1/{userId}";

    public $OK = 200;
    public $CREATED = 201;
    public $UNAUTHORIZED =401;
    public $FORBIDDEN =403;
    public $BAD_REQUEST =400;
    public $NOT_FOUND =404;
    public $SERVER_ERROR =500;


    const Debug = true;
    function __construct()
    {
    	
    	$this->boot();
    }
    function boot()
    {
    	if(strlen($this->_apiKey) == 0 || strlen($this->_userid)==0)
    	{
    		print SematimeAPIException::noCredentials();
            exit;
    		//var_dump($this);
    		
    	}
    }

}