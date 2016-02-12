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
      	if(file_exists($base.'/.env')){$dotenv = new Dotenv($base);}
      	if(file_exists($vendor.'/.env')){$dotenv = new Dotenv($vendor);}
      	$dotenv->load();
      	$this->_apiKey=getenv('API_KEY');
      	$this->_userid=getenv('USER_ID');
        if(strlen($this->_apiKey) === 0 || strlen($this->_userid)===0)
        {
        	print SematimeAPIException::noCredentials();
        }
    }

	public function init()
	{
		$this->init = Request::init()
	    ->withoutStrictSsl()        // Ease up on some of the SSL checks
		->addHeaders(['content-type'=>Mime::JSON,'apikey'=>$this->_apiKey]); // 
 		return Request::ini($this->init);
	}
	public function jsonEncode($data)
	{
		return json_encode($data);
	}
	public function put($url, $body)
	{
		return $this->init->post($url)->body($body)->send();
	}
	public function exec($url,$body)
	{
		$this->body= $this->jsonEncode($body);
		return $this->init->post($url )->body($this->body)->send();
	}
	public function get($url)
	{
		//$this->body= $this->jsonEncode($body);
		return $this->init->get($url)->send();	
	}
	public function post($url)
	{
		return $this->init->post($url)->send();
	}
	public function delete($url)
	{
		
	}

}