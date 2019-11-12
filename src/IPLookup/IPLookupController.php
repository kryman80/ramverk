<?php

namespace Anax\IPLookup;

use Anax\Commons\ContainerInjectableInterface;
use Anax\Commons\ContainerInjectableTrait;
use Anax\Model\IPValidationModel;

/**
 * IPLookup controller.
 */
class IPLookupController extends IPValidationModel implements ContainerInjectableInterface
{
    use ContainerInjectableTrait;

    /**
     * @var $diPage;
     */
    private $diPage;
    private $diRequest;

    /**
     * Initalize the controller with certain variables.
     * 
     * @var string $title
     * @var Page $diPage
     * @var Request diRequest
     */
    public function initialize()
    {
        $this->title = "IP Lookup";
        $this->diPage = $this->di->get("page");
        $this->diRequest = $this->di->get("request");
    }

    /**
     * Mount index.
     */
    public function indexAction()
    {
        $page = $this->diPage;
        $request = $this->diRequest;

        $page->add("ip-lookup/index");

        if ($request->getGet("ip")) {
            $ip = new IPValidationModel($request->getGet("ip"));
            
        }

        return $page->render([
            "title" => $this->title,
        ]);
    }
}
