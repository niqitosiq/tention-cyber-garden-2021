<?php

namespace dvegasa\cg2021\integrations\images;

use dvegasa\cg2021\models\ImageURL;
use Exception;
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

        } catch (Exception $e) {
            var_dump('EXCEPTION', $e->getMessage());
        }
        return $response;
    }

    protected function getFlickUrl(string $serverId, string $id, string $secret): string {
        return "https://live.staticflickr.com/$serverId/${id}_${secret}_b.jpg";
    }

    function getImagesByQ(string $q, int $n, string $sort='date-posted-desc'): array {
        $args = "&text=$q";
        $args .= "&perPage=$n";
        $args .= '&method=flickr.photos.search';
        $args .= "&sort=$sort";
        $response = $this->flickrCall($args);
        $json = json_decode($response->getBody());
        return $json->photos->photo;
    }

    // return ImagesURL[]
    function getRandomImagesByQ(string $q, int $n): array {
        $sorts = array(
                'date-posted-asc',
                'date-posted-desc',
                'date-taken-asc',
                'date-taken-desc',
                'interestingness-desc',
//                'interestingness-asc',
                'relevance',
        );
        shuffle($sorts);
        $photos = $this->getImagesByQ($q, 500, $sorts[0]);
        shuffle($photos);
        $photos = array_slice($photos, 0, $n);
        $res = array();
        foreach ($photos as $photo) {
            $res[] = new ImageURL($this->getFlickUrl($photo->server, $photo->id, $photo->secret));
        }
        return $res;
    }
}
