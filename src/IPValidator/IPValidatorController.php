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
            $result = null;

            $ipAddress = $this->diRequest->getGet("ip-address");
            
            foreach (explode(".", $ipAddress) as $value) {
                $value = (int) $value;
                
                if ($value > 255) {
                    $result = false;                    
                }
            }

            var_dump($result);
            $result = is_null($result) ? preg_match("/^[1-9]+\.\d+\.\d+\.\d+/", $ipAddress) : false;

            $data = [
                "ip" => $ipAddress,
                "result" => $result,
            ];

            $page->add("ip/validation", $data);
        }
        
        return $page->render([
            "title" => "IP validering",
        ]);
    }
}