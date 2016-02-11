<?php
namespace Sematime\Contracts;

Interface HttpClientInterface 
{
	public function boot();
	
	public function init();

	public function jsonEncode($data);

	public function exec($url, $body);

	public function get($url,$body= '');
	
	public function post($url);
	
	public function put($url, $body);

	public function delete($url);
	
}