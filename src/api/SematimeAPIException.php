<?php
namespace Sematime\Api\Exception;

use Exception;

class SematimeAPIException extends Exception
{
    function noConnection()
    {
        return 'No Internet connection please check your connection and try again';
    }
    function noCredentials()
    {
        return "Error Processing Request, You must provide both Api key and userID";
    }
    function toOrMessage()
    {
    	return "Please supply both to and message parameters";
    }
    function contactRequired()
    {
        return "Please supply both phone number and and parameters";
    }
    function invalidUrl()
    {
        return "Provide a valid URL";
    }
}