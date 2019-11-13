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

        $ipObj = json_decode($this->ipStack->checkIP());

        $data = [
            "ip" => $ipObj,
        ];

        // var_dump($this->ipStack);

        $page->add("ip-lookup/index", $data);

        if ($request->getGet("ip")) {
            $isAnyIPValid = false;
            
            $this->checkValidIP->checkWhichIP($request->getGet("ip"));
            
            if ($this->checkValidIP->getValidIPv4() || $this->checkValidIP->getValidIPv6()) {
                $isAnyIPValid = true;
            }
            
            $validationData = [
                "isIPValid" => $isAnyIPValid,
                "ipv4" =>  $this->checkValidIP->getValidIPv4(),
                "ipv6" =>  $this->checkValidIP->getValidIPv6(),
                "version" => $this->checkValidIP->getVersionOfIP(),
                "ip" => $ipObj->ip,
            ];
            
            $page->add("ip-lookup/validation",$validationData);
            // var_dump($this->ipStack["ip"]);            
        }

        return $page->render([
            "title" => $this->title,
        ]);
    }
}
