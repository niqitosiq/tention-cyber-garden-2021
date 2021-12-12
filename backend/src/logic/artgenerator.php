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
                        'base64text' => ArtGenerator::getBase64OfText($phrase),
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

    static function getBase64OfText (string $text): string {
        $img = imagecreatefromjpeg(__DIR__ . '\\empty.jpg');
        $size = 40;
        $x = rand(10, max([50, 700 - strlen($text) * $size]));
        $y = rand(100, 400);
        $angle = rand(-15, 15) % 3 === 0 ? 0 : rand(-15, 15);
        $quality = 100;
        $color = imagecolorallocate($img, 0, 0, 0);
        $fonts = array(
                'f (1).ttf',
                'f (2).ttf',
                'f (3).ttf',
                'f (4).ttf',
                'f (5).ttf',
                'f (6).ttf',
                'f (7).ttf',
                'f (8).ttf',
                'f (9).ttf',
                'f (10).ttf',
                'f (11).ttf',
                'f (12).ttf',
                'f (13).ttf',
        );
        shuffle($fonts);
        imagettftext($img, $size, $angle, $x, $y, $color, __DIR__ . "\\fonts\\${fonts[0]}", $text);
        $pathOutput = __DIR__ . '\\text.jpg';
        imagejpeg($img, $pathOutput, $quality);
        return base64_encode(file_get_contents($pathOutput));
    }
}
