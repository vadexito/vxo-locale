<?php

namespace VxoLocale\Controller;

use Zend\Mvc\Controller\AbstractActionController;

class LocaleController extends AbstractActionController
{
    protected $redirectRoute = 'home';
    
    public function changeAction()
    {
        $locale = $this->getRequest()->getQuery()['locale'] || $this->params()->fromRoute('locale', '');
        
        if (!$locale) {
            return $this->redirect()->toRoute($this->getRedirectRoute());
        }
        $this->getServiceLocator()->get('session-factory-service')->locale = $locale;
        
        return $this->redirect()->toRoute($this->getRedirectRoute());
    }
    
    public function setRedirectRoute($redirectRoute)
    {
        $this->redirectRoute = $redirectRoute;
    }
    
    public function getRedirectRoute()
    {
        return $this->redirectRoute;
    }
}
