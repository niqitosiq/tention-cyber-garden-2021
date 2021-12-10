<?php

namespace dvegasa\cg2021\server\restserver;

use dvegasa\cg2021\logic\memegenerator\ArtGenerator;
use Slim\App;
use Slim\Factory\AppFactory;
use Slim\Psr7\Factory\StreamFactory;
use Slim\Psr7\Request;
use Slim\Psr7\Response;
use Slim\Routing\RouteCollectorProxy;

class RestServer {
    function __construct () {
        $app = AppFactory::create();
        $this->setupRouting($app);
        $this->setupCors($app);
        $app->addErrorMiddleware(true, false, true);
        $app->run();
    }

    protected function setupRouting(App $app) {
        $app->group('/api', function(RouteCollectorProxy $api) {
            $api->any('/ping', array($this, 'ping'));
            $api->post('/requestMemes', array($this, 'requestMemes'));
            $api->get('/images/{name}', array($this, 'images'));
        });
        $app->options('/{routes:.+}', function ($request, $response, $args) {
            return $response;
        });
    }

    protected function setupCors (App $app): void {
        $app->add(function ($request, $handler) {
            $response = $handler->handle($request);
            return $response
                    ->withHeader('Access-Control-Allow-Origin', '*')
                    ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
                    ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, PATCH, OPTIONS');
        });
    }

    protected function response (Response $r, $body=null, $code=200): Response {
        if ($body !== null) {
            $r->getBody()->write(json_encode($body));
        } else {
            $r->getBody()->write('');
        }
        $r = $r->withHeader('Content-Type', 'application/json');
        $r = $r->withStatus($code);
        return $r;
    }

    protected function getPostParams(Request $req): array {
        return json_decode($req->getBody(), true) ?? array();
    }

    protected function getGetParams(Request $req): array {
        return $req->getQueryParams() ?? array();
    }


    function ping (Request $request, Response $response): Response {
        return $this->response($response, array(
                'status' => 'OK',
                'params' => array (
                        'get' => $this->getGetParams($request),
                        'post' => $this->getPostParams($request),
                ),
        ));
    }

    function requestMemes (Request $request, Response $response): Response {
        $params = $this->getPostParams($request);

        if (!isset($params['words'])) return $this->response($response, array('error' => '[words] required'), 400);
        if (count($params['words']) !== 4) return $this->response($response, array('error'=>'need 4 words'), 400);

        $ag = new ArtGenerator();
        $urls = $ag->generateByWords($params['words']);
        return $this->response($response, array(
                'urls' => $urls,
        ));
    }

    function images (Request $request, Response $response, array $args): Response {
        $name = $args['name'];
        $file = __DIR__ . '\\..\\..\\storage\\images\\' . $name;
        if (!file_exists($file)) return $this->response($response, array('error' => 'Not found', 'path' => $file), 404);
        $image = file_get_contents($file);
        return $response
                ->withBody((new StreamFactory())->createStream($image))
                ->withHeader('Content-Type', 'image/png');

    }
}


