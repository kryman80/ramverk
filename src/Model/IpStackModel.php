<?php

namespace Anax\Model;

/**
 * Model for fetching IP related information from ipstack.
 */
class IpStackModel
{
    /**
     * @var this $ipstackRespObj
     */
    private $ip;
    private $ipstackRespObj;
    protected $accessKey;
    private $ipstackBaseUrl;

    
    /**
     * Constructor.
     */
    function __construct()
    {
        $this->ip = false;
        $this->ipstackRespObj = null;
        $this->ipstackBaseUrl = "http://api.ipstack.com";
        $this->accessKey = null;
    }


    /**
     * Check IP from ipstack.
     * 
     * @return IpStackModel $ipstackRespObj
     */
    public function checkIP()
    {
        $accKey = new \Anax\AccessKey();

        $this->accessKey = $accKey->getKey();

        $curlHandle = curl_init("{$this->ipstackBaseUrl}/check?access_key={$this->accessKey}&fields=ip");
        
        curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, true);
        
        $this->ip = curl_exec($curlHandle);
        
        curl_close($curlHandle);

        return $this->ip;
    }


    public function getInfoAboutIP($ipAddr = null)
    {
        $ch = curl_init("{$this->ipstackBaseUrl}/{$ipAddr}?access_key={$this->accessKey}");
        
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $this->ipstackRespObj = curl_exec($ch);

        curl_close($ch);

        return $this->ipstackRespObj;
    }
}
