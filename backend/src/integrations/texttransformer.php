<?php

namespace dvegasa\cg2021\integrations\texttransformer;


use dvegasa\cg2021\debugger\Debugger;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Symfony\Component\Debug\Debug;

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

    protected function ppSynonyms (string $q, int $top=25): array {
        $args = "&query=$q";
        $args .= '&c=syns';
        $args .= "&top=$top";
        $args .= '&forms=0';
        $args .= '&scores=0';
        $response = $this->paraphraserCall($args);
        $json = json_decode($response->getBody(), true);
        $res = $json['response'][1]['syns'];
        return $res;
    }

    // return string[] (size=n)
    function getSynonyms(string $q, int $n): array {
        Debugger::log('TT', 'START getSynonyms. q: ' . $q . ' n: ' . $n);
        $syns = $this->ppSynonyms($q, 2);
        Debugger::log('TT', 'getSynonyms. $syns: ' . json_encode($syns, JSON_UNESCAPED_UNICODE));
        Debugger::log('TT', "FINISH getSynonyms\n\n");
        return $syns;
    }

    // string[]
    function getCommonPhrase (array $words): string {
        Debugger::log('TT', 'START getCommonPhrase. Слова: ' . json_encode($words, JSON_UNESCAPED_UNICODE));
        $topics = $this->ppWikitopics($words);
        shuffle($topics);
        Debugger::log('TT', 'getCommonPhrase. ppWikitopics: ' . json_encode($topics, JSON_UNESCAPED_UNICODE));
        $topicSynonyms = $this->ppSynonyms($topics[0]);
        shuffle($topicSynonyms);
        Debugger::log('TT', 'getCommonPhrase. $topicSynonyms: ' . json_encode($topicSynonyms, JSON_UNESCAPED_UNICODE));
        $res = explode('|', $topicSynonyms[0])[0];
        Debugger::log('TT', "FINISH getCommonPhrase\n\n");
        return $res;
    }
}
