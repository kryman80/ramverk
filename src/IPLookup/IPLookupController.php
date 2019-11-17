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
     * @var IpStackModel $ipStack
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
    public function indexAction($api = null)
    {
        $request = $this->diRequest;

        if ($api) {
            $request->setGet("ip", substr($api, 4));
        }
            
        $page = $this->diPage;

        $ipObj = json_decode($this->ipStack->checkIP());

        $data = [
            "ip" => $ipObj,
        ];

        $api ? null : $page->add("ip-lookup/index", $data);

        if ($request->getGet("ip")) {
            $isAnyIPValid = false;
            $ipstackObj = null;
            $ip = $request->getGet("ip");
            $this->checkValidIP->checkWhichIP($request->getGet("ip"));
            
            if ($this->checkValidIP->getValidIPv4() || $this->checkValidIP->getValidIPv6()) {
                $isAnyIPValid = true;
                $ipstackObj = json_decode($this->ipStack->getInfoAboutIP($ip));
            }
            
            $validationData = [
                "isIPValid" => $isAnyIPValid,
                "ipv4" =>  $this->checkValidIP->getValidIPv4(),
                "ipv6" =>  $this->checkValidIP->getValidIPv6(),
                "version" => $this->checkValidIP->getVersionOfIP(),
                "ip" => $ip,
                "api" => $api,
                "ipstack" => $ipstackObj,
            ];

            $page->add("ip-lookup/validation", $validationData);
        }

        if (!$api) {
            return $page->render([
                "title" => $this->title,
            ]);
        }
    }


    /**
     * Mount api.
     * Validating IP addresses via API and returning JSON results in some cases.
     */
    public function apiAction()
    {
        $page = $this->diPage;
        $request = $this->diRequest;
        $ipObj = json_decode($this->ipStack->checkIP());
        
        $data = [
            "ip" => $ipObj->ip,
        ];

        $page->add("ip-lookup/api", $data);

        if ($request->getGet("ip")) {
            $this->indexAction($request->getGet("ip"));
        }

        if ($request->getGet("route")) {
            $ipstack = json_decode($this->ipstack->getIPstackRespObj());

            return [[ $ipstack ]];
        }

        return $page->render([
            "title" => $this->title . " via REST API",
        ]);
    }


    /**
     * Test routes.
     *
     * @return JSON
     */
    public function apiJsonAction()
    {
        $req = $this->diRequest;

        if ($req->getGet("ip")) {
            $ip = $req->getGet("ip");
            $route = $req->getGet("route", null);
            $ipstackObj = $this->ipStack->getSpecificInfoAboutIP($ip, $route);

            return [[$ipstackObj]];
        }
    }
}
