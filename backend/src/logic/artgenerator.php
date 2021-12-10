<?php

namespace dvegasa\cg2021\logic\memegenerator;


use dvegasa\cg2021\integrations\danyaapi\DanyaAI;
use dvegasa\cg2021\integrations\texttransformer\TextTransformer;
use dvegasa\cg2021\integrations\yandeximages\YandexImages;
use dvegasa\cg2021\models\ImageURL;
use dvegasa\cg2021\storage\localstorage\LocalStorage;

class ArtGenerator {
    function generateByWords (array $words): array {
        $tt = new TextTransformer();
        $ls = new LocalStorage();
        $yimg = new YandexImages();
        $danya = new DanyaAI();

        // Для DanyaAI
        $wordsImg = array(); // ImageURL[]
        $synonymImgs = array(); // ImageURL[]
        $commonImg = $yimg->getRandomImagesByQ(implode(' ', $words), 1)[0];
        $phrase = $tt->getCommonPhrase($words);

        // Работаю с синонимами
        $synonymWords = array(); // string
        foreach ($words as $word) {
            $synonymWords[] = $tt->getSynonyms($word, 2);
            $wordsImg[] = $yimg->getRandomImagesByQ($word, 1)[0]; // Notice: обращение к YIMG
        }
        shuffle($synonymWords);
        $synonymWords = array_slice($synonymWords, 0, 4);
        foreach ($synonymWords as $synonymWord) {
            $synonymImgs = $yimg->getRandomImagesByQ($synonymWord, 1)[0];
        }

        $imgsBase64 = $danya->process($wordsImg, $commonImg, $synonymImgs, $phrase);
        $urls = array();
        foreach ($imgsBase64 as $imgBase64) {
            $id = time() . '_' . rand(1000000, 9999999) . '.png';
            $ls->saveImageFromBase64($imgBase64, $id);
            $urls[] = $_ENV['IMAGE_STORAGE_BASE_URL'] . $id;
        }
        return $urls;
    }
}
