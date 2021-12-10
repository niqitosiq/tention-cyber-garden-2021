<?php

namespace dvegasa\cg2021\main;

use Dotenv\Dotenv;

function main (array $args): void {
    loadEnvVars();
    echo 'Hello, world!';
}

function loadEnvVars() {
    Dotenv::createImmutable(__DIR__ . '\..')->load();
}
