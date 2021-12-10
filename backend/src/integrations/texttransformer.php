<?php

namespace dvegasa\cg2021\integrations\texttransformer;


class TextTransformer {
    // return string[] (size=n)
    function getSynonyms(string $word, int $n): array {
        return array();
    }

    // string[]
    function getCommonPhrase (array $words): string {
        return 'Meow';
    }
}
