<?php

namespace dvegasa\cg2021\integrations\images;

use dvegasa\cg2021\models\ImageURL;
use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;

class Images {
    protected function flickrCall (string $args): ResponseInterface {
        $url = 'http://www.flickr.com/services/rest/';
        $url .= '?api_key=' . $_ENV['FLICKR_KEY'];
        $url .= '&format=json';
        $url .= '&nojsoncallback=1';
        $url .= $args;
        $client = new Client([
                'verify' => false
        ]);
        try {
            $response = $client->get($url);

        } catch (\Exception $e) {
            var_dump('EXCEPTION', $e->getMessage());
        }
        return $response;
    }

    // return ImagesURL[]
    function getRandomImagesByQ(string $q, int $n): array {
        $args = "&text=$q";
        $args .= "&perPage=$n";
        $args .= '&method=flickr.photos.search';
        $response = $this->flickrCall($args);
        $json = json_decode($response->getBody());
        var_dump('getRandomImagesByQ', $json);

        $res = array();
        for ($i = 0; $i < $n; $i++) {
            $res[] = new ImageURL('');
        }
        return $res;
    }
}
