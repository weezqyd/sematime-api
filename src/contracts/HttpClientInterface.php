<?php
namespace Sematime\Contracts;

Interface HttpClientInterface 
{	
	public function init();

	public function jsonEncode($data);

	public function exec($url, $body);

	public function get($url);
	
	public function post($url);
	
	public function put($url, $body);

	public function delete($url);
	
}