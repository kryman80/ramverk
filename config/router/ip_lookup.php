<?php
/**
 * Routes for kmom02.
 */
return [
    "routes" => [
        [
            "info" => "IP lookup page.",
            "mount" => "ip-lookup",
            "handler" => "\Anax\IPLookup\IPLookupController",
        ],
    ],
];
