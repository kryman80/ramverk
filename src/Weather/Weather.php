<?php

namespace Anax\Weather;

use Anax\Commons\ContainerInjectableInterface;
use Anax\Commons\ContainerInjectableTrait;

/**
 * Class for the weather API service.
 */
class Weather implements ContainerInjectableInterface
{
    use ContainerInjectableTrait;

    public function greet()
    {
        return "great, perhaps it's working";
    }
}