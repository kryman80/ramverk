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
     * @var Request $diReq    $di->request.
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
     * Mount ip/api.
     * 
     * @return Page $page   Render ip/api page.
     */
    public function apiAction()
    {
        $page = $this->diPage;

        $page->add("ip/api");

        if ($this->diReq->getGet("api_ip-address")) {
            $data = [
                "json" => json_encode($this->diReq->getGet("api_ip-address")),
            ];

            $page->add("ip/api-validation", $data);
        }

        return $page->render([
            "title" => "Validate an IP via API.",
        ]);
    }
}