<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

return [
    'vxo_locale' => [
        'session' => [
            'namespace'   => 'vxo',
        ],
    ],
    'router' => [
        'routes' => [
            'locale' => [
                'type'    => 'Literal',
                'options' => [
                    'route'    => '/locale',
                    'defaults' => [
                        '__NAMESPACE__' => 'VxoLocale\Controller',
                        'controller'    => 'Locale'
                    ],
                ],
                'may_terminate' => true,
                'child_routes' => [
                    'change' => [
                        'type'    => 'Segment',
                        'options' => [
                            'route'    => '/change/[:locale]',
                            'constraints' => [
                                'locale'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ],
                            'defaults' => [
                                'action' => 'change',                                
                            ],
                        ],
                    ],
                ],
            ],
        ],
    ],
    'service_manager' => [
        'factories' => [
            'session-factory-service' => 'VxoLocale\Service\SessionFactory',
            'session-service' => 'VxoLocale\Service\SessionService',
        ],
    ],
    'controllers' => [
        'invokables' => [
            'VxoLocale\Controller\Locale' => 'VxoLocale\Controller\LocaleController'
        ],
    ],
];
