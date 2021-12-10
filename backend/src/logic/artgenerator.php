<?php

namespace dvegasa\cg2021\logic\memegenerator;


use dvegasa\cg2021\integrations\danyaapi\DanyaAI;
use dvegasa\cg2021\integrations\texttransformer\TextTransformer;
use dvegasa\cg2021\models\ImageURL;
use dvegasa\cg2021\storage\localstorage\LocalStorage;

class ArtGenerator {
    function generateByWords (array $words): array {
        $tt = new TextTransformer();
        $ls = new LocalStorage();

        $originalWords = $words;
        $synonymWords = array();
        foreach ($originalWords as $originalWord) {
            $synonymWords[] = $tt->getSynonyms($originalWord, 2);
        }
        shuffle($synonymWords);
        $commonImg = new ImageURL('');
        $phrase = $tt->getCommonPhrase($originalWords);

        $danya = new DanyaAI();
        $imgsBase64 = $danya->process($originalWords, $commonImg, array_slice($synonymWords, 0, 4), $phrase);
        $fileNames = array();
        foreach ($imgsBase64 as $imgBase64) {
            $id = time() . '_' . rand(1000000, 9999999);
            $ls->saveImageFromBase64($imgBase64, $id);
            $fileNames[] = $id;
        }
        return $fileNames;
    }
}
