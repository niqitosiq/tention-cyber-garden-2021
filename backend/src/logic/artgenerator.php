<?php

namespace dvegasa\cg2021\logic\memegenerator;


use dvegasa\cg2021\integrations\danyaapi\DanyaAI;
use dvegasa\cg2021\integrations\texttransformer\TextTransformer;
use dvegasa\cg2021\integrations\images\Images;
use dvegasa\cg2021\models\ImageURL;
use dvegasa\cg2021\storage\localstorage\LocalStorage;

class ArtGenerator {

    function generateByWords (array $words): array {
        $tt = new TextTransformer();
        $ls = new LocalStorage();
        $yimg = new Images();
        $danya = new DanyaAI();

        // Для DanyaAI
        $wordsImg = array(); // ImageURL[]
        $synonymImgs = array(); // ImageURL[]
//        $commonImg = $yimg->getRandomImagesByQ(implode(' ', $words), 1)[0]; // TODO: Поиск общей фотографии
        $commonImg = $yimg->getRandomImagesByQ($words[1], 1)[0];
        $phrase = $tt->getCommonPhrase($words);

        // Работаю с синонимами
        $synonymWords = array(); // string
        foreach ($words as $word) {
            $synonyms = $tt->getSynonyms($word, 2);
            foreach ($synonyms as $synonym) {
                $synonymWords[] = $synonym;
            }
            $wordsImg[] = $yimg->getRandomImagesByQ($word, 1)[0];
        }
        shuffle($synonymWords);
        $synonymWords = array_slice($synonymWords, 0, 4);
        foreach ($synonymWords as $synonymWord) {
            $synonymImgs[] = @$yimg->getRandomImagesByQ($synonymWord, 1)[0];
        }
        $res = array(
                'results' => array(),
                'sources' => array (
                        'synonymWords' => $synonymWords,
                        'phrase' => $phrase,
                        'wordsImg' => $wordsImg,
                        'commonImg' => $commonImg,
                        'synonymImgs' => $synonymImgs,
                ),
        );

        $imgsBase64 = $danya->process($res);
        $urls = array();
        foreach ($imgsBase64 as $imgBase64) {
            $id = time() . '_' . rand(1000000, 9999999) . '.png';
            $ls->saveImageFromBase64($imgBase64->base64, $id);
            $urls[] = $_ENV['IMAGE_STORAGE_BASE_URL'] . $id;
        }
        $res['results'] = $urls;
        return $res;
    }
}
