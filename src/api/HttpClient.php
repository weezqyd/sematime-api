<?php
namespace Sematime\Api;

use Httpful\Request;
use Httpful\Mime;
use Httpful\Http;
use Sematime\Api\Sematime;

Class HttpClient extends Sematime // implements HttpClientInterface
{
	public $init;

	function __construct()
	{
		parent::__construct();
		$this->init();
	}

	public function init()
	{
		$this->init = Request::init()
	    ->withoutStrictSsl()        // Ease up on some of the SSL checks
		->addHeaders(['content-type'=>Mime::JSON,'apikey'=>$this->_apiKey]);
 		return Request::ini($this->init);
	}
	public function sendMessage($to, $message, $options='')
	{
		$this->_responseBody=$this->jsonEncode([
						'message'    => $message,
		            	'recipients' => implode(',',$to),
					   ]);
		$this->_requestUrl = str_replace('{userId}', $this->_userid, $this->SMS_URL);
		$this->response=$this->init->post($this->_requestUrl )->body($this->_responseBody)->send();
		return $this->response ;
		//var_dump($this);

	}
	public function jsonEncode($data)
	{
		return json_encode($data);
	}
	public function addContact($contacts)
	{
		
	}

}