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

    private $appPage;

    public function initialize() : void
    {
        // $this->appPage = $this->app->page;
    }

    public function indexAction()
    {       
        $page = $this->di->page; 
        $page->add("ip/index");
        
        return $page->render([
            "title" => "IP validering",
        ]);
    }
}