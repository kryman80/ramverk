<?php
/**
 * Routes for API IP validation.
 */
return [
    "routes" => [
        [
            "info" => "API IP validator.",
            "mount" => "ip",
            "handler" => "\Anax\IPValidator\APIIPValidatorController",
        ],
    ],
];