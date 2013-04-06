<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace VxoLocale;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Locale;

class Module
{
    public function onBootstrap(MvcEvent $e)
    {
        $services = $e->getApplication()->getServiceManager();
        $em = $e->getApplication()->getEventManager();
        
        $session = $services->get('session-factory-service');
        if ($session->locale){            
            $locale = $session->locale;
        } else {
            $locale = Locale::getDefault();
            $session->locale = $locale;
        }
        Locale::setDefault($locale);
        
        if ($services->get('translator')){
            $services->get('translator')->setLocale($locale)
                                    ->setFallbackLocale('en_US');
        }
    }
    
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }
    
    public function getViewHelperConfig()
    {
        return [
            'factories' => [
                'language' => function ($sm) {   
                    $session = $sm->getServiceLocator()->get('session-factory-service');
                    $viewHelper = new View\Helper\Language();
                    $viewHelper->setSession($session);
                    return $viewHelper;
                },
            ],
        ];
    }
}
