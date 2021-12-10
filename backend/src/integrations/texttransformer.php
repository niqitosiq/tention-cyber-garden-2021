<?php

namespace dvegasa\cg2021\integrations\texttransformer;


use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\ResponseInterface;

class TextTransformer {

    protected function paraphraserCall (string $args): ResponseInterface {
        $url = 'http://paraphraser.ru/api/';
        $url .= '?token=' . $_ENV['PARAPHRASER_TOKEN'];
        $url .= '&lang=ru';
        $url .= '&format=json';
        $url .= $args;

        $client = new Client();
        $response = $client->get($url);
        return $response;
    }

    protected function ppWikitopic (array $words): array {
        shuffle($words);
        $args = '&query=' . implode(' ', $words);
        $args .= '&c=wikitopic';
        $response = $this->paraphraserCall($args);
        $json = json_decode($response->getBody());
        return $json?->response?->topics ?? array();
    }

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
        $variants = $this->ppWikitopic($words);
        var_dump($variants);
        shuffle($variants);
        return $variants[0];
    }
}
