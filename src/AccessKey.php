<?php

namespace Anax;

class AccessKey
{
    protected $key;

    public function getKey()
    {
        $fileContent = json_decode(file_get_contents("../.private"));
        $this->key = $fileContent->access_key;
        
        return $this->key;
    }
}