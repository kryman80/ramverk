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
    protected $accessKey;

    
    /**
     * Constructor.
     */
    function __construct()
    {
        $this->ip = false;
        $this->ipStackRespObj = null;
    }


    /**
     * Check IP from ipstack.
     * 
     * @return IpStackModel $ipStackRespObj
     */
    public function checkIP()
    {
        $accKey = new \Anax\AccessKey();

        $this->accessKey = $accKey->getKey();

        $curlHandle = curl_init("http://api.ipstack.com/check?access_key=$this->accessKey&fields=ip");
        
        curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, true);
        
        $this->ip = curl_exec($curlHandle);
        
        curl_close($curlHandle);

        return $this->ip;
    }


    public function getInfoAboutIP($ipAddr = null)
    {
        // $ch = curl_init("")
    }
}
