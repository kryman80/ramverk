<?php

namespace Anax\Model;


/**
 * Model for fetching IP related information from ipstack.
 */
class IpStackModel
{
    /**
     * @var this $ipStackRespObj
     */
    private $ip;
    private $ipStackRespObj;

    
    /**
     * Constructor.
     */
    function __construct()
    {
        $this->ip = false;
        $this->ipStackRespObj = null;
        // $this->checkIP();
    }


    /**
     * Check IP from ipstack.
     * 
     * @return IpStackModel $ipStackRespObj
     */
    public function checkIP()
    {
        $curlHandle = curl_init("http://api.ipstack.com/check?access_key=fbe5349ecdc9b017fac1eaa1e2d32598&fields=ip");
        
        curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, true);
        
        $this->ip = curl_exec($curlHandle);
        
        curl_close($curlHandle);

        return $this->ip;
    }
}
