<?php
namespace Sematime\Contracts;

Interface CurlContract
{
	 function curlInitialize();
	
	 function Execute($curlHandle_);

	 function setCurlOpts($curlHandle_);
}