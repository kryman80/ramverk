<?php

namespace Anax\IPValidator;

use Anax\Commons\ContainerInjectableInterface;
use Anax\Commons\ContainerInjectableTrait;


/**
 * Controller for validating IP addresses by API.
 */
class APIIPValidatorController implements ContainerInjectableInterface
{
    use ContainerInjectableTrait;


    /**
     * Local members.
     * 
     * @var Page $diPage    $di->page.
     * @var Request $diReq  $di->request.
     */
    private $diPage;
    private $diRequest;
    
    /**
     * Initializing members.
     */
    public function initialize()
    {
        $this->diPage = $this->di->page;
        $this->diReq = $this->di->get("request");
    }


    /**
     * Mount api; api/index.
     * 
     * @return Page $page   Render ip/api page.
     */
    public function indexAction()
    {
        $page = $this->diPage;

        $page->add("api/index");
        
        if ($this->diReq->getGet("api_ip-address")) {
            $ipAddress = $this->diReq->getGet("api_ip-address");

            if (strpos($ipAddress, "ip4 ") > -1) {
                $ipAddress = str_replace("ip4 ", "", $ipAddress);
            } else if (strpos($ipAddress, "ip6 ") > -1) {
                $ipAddress = str_replace("ip6 ", "", $ipAddress);
            } else {
                $ipAddress = false;
            }            

            $result = checkWhichIP($ipAddress);

            $data = [
                "ip" => json_encode($ipAddress),
                "result" => $result,
                "ip4" => strpos($ipAddress, ".") ? json_encode("ip4") : json_encode("ip6"),
                "hostname" => json_encode(@gethostbyaddr($ipAddress)),
            ];

            $page->add("api/validation", $data);
        }

        return $page->render([
            "title" => "Validate an IP via API.",
        ]);
    }
}