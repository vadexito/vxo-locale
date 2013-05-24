<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace VxoLocale;

use Zend\Mvc\MvcEvent;
use Locale;
use Zend\ModuleManager\Feature\BootstrapListenerInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\ModuleManager\Feature\AutoloaderProviderInterface;

class Module implements 
    BootstrapListenerInterface,
    ConfigProviderInterface,
    AutoloaderProviderInterface
{
    public function onBootstrap(MvcEvent $e)
    {
        $services = $e->getApplication()->getServiceManager();
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
                    $sl = $sm->getServiceLocator();
                    $session = $sl->get('session-factory-service');
                    $viewHelper = new View\Helper\Language();
                    $viewHelper->setSession($session);
                    $languages =$sl->get('config')['vxolocale']['languages'];
                    $viewHelper->setLanguages($languages);
                    return $viewHelper;
                },
                'selectLanguage' => function ($sm) {  
                    $sl = $sm->getServiceLocator();
                    $viewHelper = new View\Helper\SelectLanguage();
                    $languages =$sl->get('config')['vxolocale']['languages'];
                    $viewHelper->setLanguages($languages);
                    return $viewHelper;
                },
            ],
        ];
    }
}
