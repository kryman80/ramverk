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
            $ipAddress = $this->diRequest->getGet("ip-address");
            
            $result = checkWhichIp($ipAddress);
            
            $data = [
                "ip" => $ipAddress,
                "result" => $result,
                "ip4" => strpos($ipAddress, "."),
                "hostname" => @gethostbyaddr($ipAddress),
            ];

            $page->add("ip/validation", $data);
        }
        
        return $page->render([
            "title" => "IP validering",
        ]);
    }
}