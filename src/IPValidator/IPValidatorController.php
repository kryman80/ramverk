<?php

namespace Anax\IPValidator;

use Anax\Commons\ContainerInjectableInterface;
use Anax\Commons\ContainerInjectableTrait;

/**
 * Controller for IP validation.
 */
class IPValidatorController implements ContainerInjectableInterface
{
    use ContainerInjectableTrait;

    
    /**
     * Properties.
     * 
     * @var Page $diPage        $di->page.
     * @var Request $diRequest  $di->get("request").
     */
    private $diPage;
    private $diRequest;


    /**
     * Initializing controller (class) members.
     */
    public function initialize() : void
    {
        $this->diPage = $this->di->page;
        $this->diRequest = $this->di->get("request");
    }


    /**
     * Function page for index.
     * 
     * Mount points:
     * ip
     * ip/index
     * 
     * @return object       Renders index page.
     */
    public function indexAction()
    {
        $page = $this->diPage;

        $page->add("ip/index");
        
        if ($this->diRequest->getGet("ip-address")) {
            $result = null; $ip4 = false; $ip6 = false;

            $ipAddress = $this->diRequest->getGet("ip-address");

            strlen($ipAddress) < 32 ? $ip4 = true : $ip6 = true;

            if ($ip4) {
                foreach (explode(".", $ipAddress) as $value) {
                    if (strlen($value) > 3) {
                        $result = false;
                        break;
                    }
    
                    $value = (int) $value;
                    
                    if ($value > 255) {
                        $result = false;
                        break;
                    }
                }
            } else if ($ip6) {
                $ip6AddressArray = explode(":", $ipAddress);

                if (count($ip6AddressArray) != 8) {
                    $result = false;
                } else {
                    foreach ($ip6AddressArray as $value) {
                        if (strlen($value) != 4) {
                            $result = false;
                            break;
                        }
                    }
                }
            }
            
            if (is_null($result)) {
                $ip6P = "[0-9A-Fa-f]";
                
                $result = $ip4 ? preg_match("/^[1-9]+\.\d+\.\d+\.\d+/", $ipAddress)
                : ($ip6 ? preg_match(
                    "/^$ip6P+\:$ip6P+\:$ip6P+\:$ip6P+\:$ip6P+\:$ip6P+\:$ip6P+\:$ip6P+/", $ipAddress
                    ) : false);
            }            
            
            $data = [
                "ip" => $ipAddress,
                "result" => $result,
                "ip4" => strpos($ipAddress, "."),
                "hostname" => gethostbyaddr($ipAddress),
            ];

            $page->add("ip/validation", $data);
        }
        
        return $page->render([
            "title" => "IP validering",
        ]);
    }
}