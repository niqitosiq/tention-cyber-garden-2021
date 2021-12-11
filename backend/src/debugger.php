<?php

namespace dvegasa\cg2021\debugger;


class Debugger {
    const PATH = __DIR__ . '\\..\\debug\\';

    static string $RUN = '';

    static function init () {
        Debugger::$RUN = time() . '_' . rand(1000, 9999);
        Debugger::log('Debugger', 'Run ' . self::$RUN);
    }

    static function log (string $key, string $value) {
        if ($_ENV['DEBUG'] !== 'yes') return;
        file_put_contents(
                filename: Debugger::PATH . self::$RUN . '.log',
                data: "$key: $value\n",
                flags: FILE_APPEND,
        );
    }
}
