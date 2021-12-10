<?php

namespace dvegasa\cg2021\logic\memegenerator;


use dvegasa\cg2021\integrations\danyaapi\DanyaAI;
use dvegasa\cg2021\models\ImageURL;

class ArtGenerator {
    function generateByWords (array $words): array {

        $originalWords = $words;
        $synonymWords = array();
        $commonImg = new ImageURL('');
        $phrase = '';

        $danya = new DanyaAI();
        $imgsBase64 = $danya->process($originalWords, $commonImg, $synonymWords, $phrase);
        return array('https://');
    }
}
