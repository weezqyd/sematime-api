<?php
namespace Sematime\Api;

use Httpful\Request;
use Httpful\Mime;
use Httpful\Http;
use Sematime\Contracts\HttpClientInterface;
use Dotenv\Dotenv;


Class HttpClient implements HttpClientInterface
{
	public $init;

	function __construct()
	{
		$this->boot();
		$this->init();
    }
    public function boot()
    {
      	$base = realpath(__DIR__.'/../../'); 
      	$vendor = realpath(__DIR__.'/../../../../../');
      	
      	// check if .env file exists inbase  package directory
      	if(file_exists($base.'/.env')){$dotenv = new Dotenv($base);}

      	// check if .env file exists in root directory
      	if(file_exists($vendor.'/.env')){$dotenv = new Dotenv($vendor);} 
      	$dotenv->load(); 
      	$this->_apiKey=getenv('API_KEY'); //get api key from env file 
      	$this->_userid=getenv('USER_ID'); // get user DI from env file 
        if(strlen($this->_apiKey) === 0 || strlen($this->_userid)===0)
        {
        	print SematimeAPIException::noCredentials();
        }
    }
    /**
    * @param null
    * */
    /*-----------------------------------------
    *| Create a template for all requests send
    *|
    */

	public function init()
	{
		$this->init = Request::init()
	    ->withoutStrictSsl()        // Ease up on some of the SSL checks
		->addHeaders(['content-type'=>Mime::JSON,'apikey'=>$this->_apiKey]); // add api key to headers
 		return Request::ini($this->init);
	}
	/*
		Json Encode request body before being send
	*/
	public function jsonEncode($data)
	{
		return json_encode($data);
	}
	/*
	--------------------
	| Make a put Request
	--------------------
	 Takes the url and the request body to send a put requests
	*/
	public function put($url, $body)
	{
		$this->body=$this->jsonEncode($body);
		//return $url;
		return $this->init->put($url,$this->body)->send();
	}
	// Make post request with a request body
	public function exec($url,$body)
	{
		$this->body= $this->jsonEncode($body);
		return $this->init->post($url )->body($this->body)->send();
	}
	// make a get request
	public function get($url)
	{
		//$this->body= $this->jsonEncode($body);
		return $this->init->get($url)->send();	
	}
	// makes a plain post request
	public function post($url)
	{
		return $this->init->post($url)->send();
	}
	public function delete($url)
	{
		
	}

}