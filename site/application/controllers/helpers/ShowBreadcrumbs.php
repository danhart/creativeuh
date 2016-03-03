<?php

class Zend_Controller_Action_Helper_ShowBreadcrumbs extends Zend_Controller_Action_Helper_Abstract
{   
    public function preDispatch()
    {   
	  $layout = Zend_Layout::getMvcInstance();
	  $layout->showBreadcrumbs = true;
	  // $layout->showSlideshow = true;
    }
}