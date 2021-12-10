<?php

namespace dvegasa\cg2021\integrations\danyaapi;


use dvegasa\cg2021\models\ImageURL;

class DanyaAI {
    function process (
            array $forWords, // ImageURL[] (size=4)
            ImageURL $common,
            array $forSynonyms, // ImageURL[] (size=4)
            string $phrase,
    ): array { // ImageBase64[] (size=?)
        // TODO
        return array();
    }
}
