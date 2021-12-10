<?php

namespace dvegasa\cg2021\integrations\texttransformer;


class TextTransformer {
    // return string[] (size=n)
    function getSynonyms(string $word, int $n): array {
        $res = array();
        for ($i = 0; $i < $n; $i++) {
            $res[] = '';
        }
        return $res;
    }

    // string[]
    function getCommonPhrase (array $words): string {
        return 'Meow';
    }
}
