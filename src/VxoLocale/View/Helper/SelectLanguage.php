<?php 

namespace VxoLocale\View\Helper;

use Zend\View\Helper\AbstractHelper;
use Zend\Stdlib\Parameters;

class SelectLanguage extends AbstractHelper
{
    protected $languages;
    
    public function __invoke()
    {
        return $this->render();
        
    }
    
    public function renderListLanguages()
    {
        $items = [];
        foreach ($this->getLanguages()->get('authorized') as $locale => $language){            
            $title = $this->getView()->translate($language['name']);
            $url = $this->getView()->url('locale/change',['locale' => $locale]);
            $items[] = '<a class="language" role="menuitem" tabindex="-1" title="'
                . $title . '" href="'.$url.'">'.$language['localName'].'</a>';
        }
        
        $attribs = [
            'id' => 'menu1',
            'class' => 'dropdown-menu',
            'aria-labelledby' => 'drop_languages',
            
        ];
        
        return $this->getView()->htmlList($items, false,$attribs, false);
    }
    
    public function render()
    {
        $title = $this->getView()->translate('Language: ').$this->getView()->language();
        $linkTitle = '<a class="dropdown-toggle" id="drop_languages" role="button" data-toggle="dropdown"><h5 id="language_title">'
            .$title.' <b class="caret"></b></h5></a>';
        
        return '<ul><li class="footer-item dropdown">'
            .$linkTitle
            .$this->renderListLanguages()
            .'</li></ul>';
    }
    
    public function setLanguages(Array $languages)
    {
        $this->languages = new Parameters($languages);
    }
    
    public function getLanguages()
    {
        return $this->languages;
    }
}