<?php

namespace App\Action;

use Zend\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class PlayAction
{
    public function __construct($musicFiles)
    {
        $this->musicFiles = $musicFiles;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, callable $next = null)
    {
        $file = $request->getAttribute('file');

        $this->musicFiles->setCurrentlyPlaying($file);

        // pusher

        return new JsonResponse(['result' => 'Playing '. $file]);
    }
}
