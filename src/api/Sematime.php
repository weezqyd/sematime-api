<?php
namespace Sematime\Api;

use Sematime\Api\Exception\SematimeAPIException;
use Dotenv\Dotenv;
/**
* 
*/
class Sematime
{
	
	public $_apiKey ;
    public $_userid ;
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


    const Debug = false;
    function __construct()
    {
    	
    	$this->boot();
    }
    function boot()
    {
        $dotenv = new Dotenv(realpath(__DIR__.'/../../'));
        $dotenv->load();
        $this->_apiKey=getenv('API_KEY');
        $this->_userid=getenv('USER_ID');
    	if(strlen($this->_apiKey) == 0 || strlen($this->_userid)==0)
    	{
    		print SematimeAPIException::noCredentials();
            exit;
    		//var_dump($this);
    		
    	}
    }

}
