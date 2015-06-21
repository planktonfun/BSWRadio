<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

return array(
    'router' => array(
        'routes' => array(
            'home' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/',
                    'defaults' => array(
                        'controller' => 'BSWRadio\Controller\Index',
                        'action'     => 'index',
                    ),
                ),
            ),
            'dj_client' => array(
                'type' => 'Segment',
                'options'   => array(
                    'route'     => '[/:action]',
                    'defaults'  => array(
                        'controller' => 'BSWRadio\Controller\Index',
                        'action'     => ':action'
                    ),
                ),
            ),
            'ajax'    => array(
                'type'    => 'Segment',
                'options' => array(
                    'route'    => '/ajax[/:action]/',
                    'defaults' => array(
                        'controller' => 'BSWRadio\Controller\Ajax',
                        'action'     => ':action',
                    ),
                ),
            ),
        ),
    ),
    'controllers' => array(
        'invokables' => array(
            'BSWRadio\Controller\Index' => 'BSWRadio\Controller\IndexController',
            'BSWRadio\Controller\Ajax' => 'BSWRadio\Controller\AjaxController'
        ),
    ),
    'view_manager' => array(
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => array(
            'layout/layout'           => __DIR__ . '/../view/layout/layout.phtml',
            'bswradio/index/index' => __DIR__ . '/../view/bswradio/index/index.phtml',
            'error/404'               => __DIR__ . '/../view/error/404.phtml',
            'error/index'             => __DIR__ . '/../view/error/index.phtml',
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
    // Placeholder for console routes
    'console' => array(
        'router' => array(
            'routes' => array(
            ),
        ),
    ),
);