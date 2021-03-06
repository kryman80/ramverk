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
        $this->diPage = $this->di->get("page");
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

            // $result = checkWhichIP($ipAddress);
            $IPValidator = new \Anax\Model\IPValidationModel();
            $result = $IPValidator->checkWhichIP($ipAddress);

            // $data = [
            //     "ip" => json_encode($ipAddress),
            //     "result" => $result,
            //     "ip4" => strpos($ipAddress, ".") ? json_encode("ip4") : json_encode("ip6"),
            //     "hostname" => json_encode(@gethostbyaddr($ipAddress)),
            // ];

            $data = [
                "ip" => $ipAddress,
                "result" => $result,
                "type" => $IPValidator->getValidIPv4() ? "ipv4" : ($IPValidator->getValidIPv6() ? "ipv6" : false),
                "hostname" => @gethostbyaddr($ipAddress),
            ];

            // $page->add("api/validation", $data);
            return [ $data ];
        }

        return $page->render([
            "title" => "Validate an IP via API.",
        ]);
    }

    public function jsonAction()
    {
        $req = $this->diReq->getGet("ip4") ?? $this->diReq->getGet("ip6") ?? false;
        
        if (!$req) {
            return [ ["error" => "Check your parameters."] ];
        }

        $res = [ "ip4" => $this->diReq->getGet("ip4"), "ip6" => $this->diReq->getGet("ip6") ];

        return [$res];
    }
}
