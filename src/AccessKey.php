<?php

namespace Anax;

/**
 * Class for fetching the access key for the ipstack API.
 * This key will not be pushed to the GitHub repo (.gitignore).
 */
class AccessKey
{
    /**
     * @var AccessKey $key  Store the access key from a file.
     */
    protected $key;


    /**
     * Get the access key.
     *
     * @return AccessKey $key
     */
    public function getKey()
    {
        $fileContent = json_decode(file_get_contents(ANAX_INSTALL_PATH . "/.private"));
        $this->key = $fileContent->access_key;
        
        return $this->key;
    }
}
