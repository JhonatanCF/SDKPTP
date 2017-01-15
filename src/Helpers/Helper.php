<?php

namespace JhonatanCF5\Helpers;

class Helper
{
    public static function studly($value)
    {
        $result = ucwords(str_replace('_', ' ', $value));
        return str_replace(' ', '', $result);
    }

    public static function getIpAddress()
    {
        $ipaddress = '127.0.0.1';

	    if (getenv('HTTP_CLIENT_IP')){
	        $ipaddress = getenv('HTTP_CLIENT_IP');
	    }
	    else if(getenv('HTTP_X_FORWARDED_FOR')){
	        $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
	    }
	    else if(getenv('HTTP_X_FORWARDED')){
	        $ipaddress = getenv('HTTP_X_FORWARDED');
	    }
	    else if(getenv('HTTP_FORWARDED_FOR')){
	        $ipaddress = getenv('HTTP_FORWARDED_FOR');
	    }
	    else if(getenv('HTTP_FORWARDED')){
	       $ipaddress = getenv('HTTP_FORWARDED');
	    }
	    else if(getenv('REMOTE_ADDR')){
	        $ipaddress = getenv('REMOTE_ADDR');
	    }

	    return $ipaddress;
    }

    public static function getClientBrowser()
    {
    	return $_SERVER['HTTP_USER_AGENT'];
    }
}