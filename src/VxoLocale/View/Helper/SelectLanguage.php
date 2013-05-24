<?php 

namespace VxoLocale\View\Helper;

use Zend\View\Helper\AbstractHelper;
use Zend\Stdlib\Parameters;
use Zend\View\Helper\AbstractHtmlElement;

class SelectLanguage extends AbstractHtmlElement
{
    protected $languages;
    protected $_label = NULL;
    
    public function __invoke()
    {
        return $this;
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
            'href' => '#',
            
        ];
        
        return $this->getView()->htmlList($items, false,$attribs, false);
    }
    
    public function __toString()
    {
        if (!$this->_label){
            $this->setLabel('Language: '.$this->getView()->language());
        }
        $linkAttrib = [
            'class' => 'dropdown-toggle',
            'id' => 'drop_languages',
            'data-toggle' => 'dropdown',
        ];
        
        $linkTitle = '<a '.$this->htmlAttribs($linkAttrib).'><h5 id="language_title">'
            .$this->getLabel().' <b class="caret"></b></h5></a>';
        
        return '<ul><li class="footer-item dropdown">'
            .$linkTitle
            .$this->renderListLanguages()
            .'</li></ul>';
    }
    
    public function setLabel($label)
    {
        $this->_label = $label;
        return $this;
    }
    
    public function getLabel()
    {
        return $this->_label;
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
