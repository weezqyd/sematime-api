<?php
namespace Sematime\Api;

use Sematime\Contracts\CurlContract;
use Sematime\Api\Sematime;

class CurlHandler extends Sematime implements CurlContract
{
    function __construct()
    {
        parent::__construct();

    }
	public function curlInitialize()
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_POSTFIELDS, $this->_requestBody);
        curl_setopt($ch, CURLOPT_POST, 1);
        $this->Execute($ch);
        return $this;
    }
     public function Execute($curlHandle_)
    {
        try
        {

            $this->setCurlOpts($curlHandle_);
            $responseBody = curl_exec($curlHandle_);

            if (self::Debug)
            {
                echo "Full response: " . print_r($responseBody, true) . "\n";
            }

            $this->_responseInfo = curl_getinfo($curlHandle_);

            $this->_responseBody = $responseBody;
            curl_close($curlHandle_);
        }

        catch (SematimeAPIException $e)
        {
            curl_close($curlHandle_);
            print $e;
        }
    }
     public function setCurlOpts($curlHandle_)
    {
        curl_setopt($curlHandle_, CURLOPT_TIMEOUT, 60);
        curl_setopt($curlHandle_, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curlHandle_, CURLOPT_URL, $this->_requestUrl);
        curl_setopt($curlHandle_, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curlHandle_, CURLOPT_HTTPHEADER, array('Content-Type: application/json',
                'apikey: ' . $this->_apiKey));
 	}/*
    public function checkConn()
    {
        //var_dump($this);
        $url=str_replace("{userId}", $this->_userid, $this->URL);
        if()
        {
            return TRUE;
        }
        else
        {
            return FALSE;

        }
    }   */
 }