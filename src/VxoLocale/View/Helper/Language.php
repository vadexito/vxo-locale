<?php 

namespace VxoLocale\View\Helper;

use Zend\View\Helper\AbstractHelper;
use Zend\Session\Container as Session;

class Language extends AbstractHelper
{
    protected $session;
    
    public function __invoke()
    {
        switch($this->getSession()->locale){
            case 'de_DE' :
                return $this->getView()->translate('German');
            case 'fr_FR' :
                return $this->getView()->translate('French');
            case 'en_US' :
                return $this->getView()->translate('English');
            default:
                return '';
        }
    }
    
    public function setSession(Session $session)
    {
        $this->session = $session;
    }
    
    public function getSession()
    {
        return $this->session;
    }
}