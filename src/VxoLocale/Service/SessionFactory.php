<?php

namespace VxoLocale\Service;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Session\Container as Session;

class SessionFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $config  = $serviceLocator->get('config');
        $nameSession = $config['vxolocale']['session']['namespace'].'_locale';
        return new Session($nameSession);
    }
}
