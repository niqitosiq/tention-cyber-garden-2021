<?php

namespace dvegasa\cg2021\main;

use Dotenv\Dotenv;
use dvegasa\cg2021\debugger\Debugger;
use dvegasa\cg2021\server\restserver\RestServer;


function main (array $args): void {
    loadEnvVars();
    $restServer = new RestServer();
}

function loadEnvVars() {
    Dotenv::createImmutable(__DIR__ . '\..')->load();
}
