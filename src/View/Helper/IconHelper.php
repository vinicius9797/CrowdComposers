<?php
namespace App\View\Helper;

use Cake\View\Helper\HtmlHelper;

    class IconHelper extends HtmlHelper{
        public $helpers = ['Html'];
        /**
        * Create MDI icon
        *
        * @param $icon Name of the icon.
        */       
        public function mdIcon ($icon, $options = []){
            $options = $this->addClass($options, 'mdi');
            $options = $this->addClass($options, 'mdi-'.$icon);

            return $this->tag('md', '', $options);
        }


    }
?>