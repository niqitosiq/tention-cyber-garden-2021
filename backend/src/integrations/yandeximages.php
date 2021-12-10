<?php

namespace dvegasa\cg2021\integrations\yandeximages;

use dvegasa\cg2021\models\ImageURL;

class YandexImages {
    // return ImagesURL[]
    function getRandomImagesByQ(string $q, int $n): array {
        $res = array();
        for ($i = 0; $i < $n; $i++) {
            $res[] = new ImageURL('');
        }
        return $res;
    }
}
