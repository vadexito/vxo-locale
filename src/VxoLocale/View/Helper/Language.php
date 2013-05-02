<?php 

namespace VxoLocale\View\Helper;

use Zend\View\Helper\AbstractHelper;
use Zend\Session\Container as Session;
use Locale;
use Zend\Stdlib\Parameters;

class Language extends AbstractHelper
{
    protected $session;
    protected $languages;
    
    public function __invoke($translate = true)
    {
        $languages = new Parameters($this->getLanguages());
        
        $locale = Locale::getDefault();
        
        foreach ($languages->get('authorized') as $authLocale => $language) {
            $language = new Parameters($language);
            if ($locale === $authLocale 
                    || in_array($locale,$language->get('alias',[]))){
                if ($translate === true){
                    return $this->getView()->translate($language->get('name'));
                }
                return $language->get('name');
            }
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
    
    public function setLanguages(Array $languages)
    {
        $this->languages = $languages;
    }
    
    public function getLanguages()
    {
        return $this->languages;
    }
}