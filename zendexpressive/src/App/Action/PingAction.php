<?php

namespace App\Action;

use Zend\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class PingAction
{
    public function __construct($musicFiles)
    {
        $this->musicFiles = $musicFiles;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, callable $next = null)
    {
        $files = $this->musicFiles->get();

        file_put_contents($this->musicFiles->getIndexFilepath(), json_encode($files));

        return new JsonResponse(['result' => 'List generated.']);
    }
}
