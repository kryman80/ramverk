<?php

namespace Anax\IPLookup;

use Anax\Commons\ContainerInjectableInterface;
use Anax\Commons\ContainerInjectableTrait;
use Anax\Model\IPValidationModel;
use Anax\Model\IpStackModel;

/**
 * IPLookup controller.
 */
class IPLookupController implements ContainerInjectableInterface
{
    use ContainerInjectableTrait;

    /**
     * @var $diPage
     * @var $diRequest
     */
    private $diPage;
    private $diRequest;

    /**
     * Initalize the controller with certain variables.
     * 
     * @var string $title
     * @var Page $diPage
     * @var Request diRequest
     * @var IPValidationModel $checkValidIP
     */
    public function initialize()
    {
        $this->title = "IP Lookup";
        $this->diPage = $this->di->get("page");
        $this->diRequest = $this->di->get("request");
        $this->checkValidIP = new IPValidationModel();
        $this->ipStack = new IpStackModel();
    }

    /**
     * Mount index.
     */
    public function indexAction()
    {
        $page = $this->diPage;

        $request = $this->diRequest;

        $data = [
            "ip" => json_decode($this->ipStack->checkIP()),
        ];

        // var_dump($this->ipStack);

        $page->add("ip-lookup/index", $data);

        if ($request->getGet("ip")) {
            $this->checkValidIP->checkWhichIP($request->getGet("ip"));
            // var_dump($this->ipStack["ip"]);
            // $page->add("")
        }

        return $page->render([
            "title" => $this->title,
        ]);
    }
}
