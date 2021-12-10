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

    protected function ppWikitopics (array $words): array {
        $args = '&query=' . implode(' ', $words);
        $args .= '&c=wikitopic';
        $response = $this->paraphraserCall($args);
        $json = json_decode($response->getBody());
        return $json?->response?->topics ?? array();
    }

    protected function ppSynonyms (string $q): array {
        $args = "&query=$q";
        $args .= '&c=syns';
        $args .= '&top=25';
        $args .= '&forms=0';
        $args .= '&scores=0';
        $response = $this->paraphraserCall($args);
        $json = json_decode($response->getBody(), true);
        $res = $json['response'][1]['syns'];
        return $res;
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
        $topics = $this->ppWikitopics($words);
        shuffle($topics);
        $topicSynonyms = $this->ppSynonyms($topics[0]);
        shuffle($topicSynonyms);
//        var_dump(array(
//                'words' => $words,
//                'topic' => $topics,
//                'topic[0]Synonyms' => $topicSynonyms,
//        ));
        $res = explode('|', $topicSynonyms[0])[0];
        var_dump('getCommonPrase.res', $res);
        return $res;
    }
}
