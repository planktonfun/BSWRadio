<?php

namespace App\Action;

use Interop\Container\ContainerInterface;
use Zend\Expressive\Router\RouterInterface;
use Zend\Expressive\Template\TemplateRendererInterface;

class PlayFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $musicFiles = $container->get(\App\Services\MusicFiles::class);
        $musicFiles->setConfig($container->get('config'));

        return new PlayAction($musicFiles);
    }
}
