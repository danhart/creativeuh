<?php

class IndexController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
	// Could change the layout like this? might be useful
	// $layout = $this->_helper->layout();
	// $layout->setLayout('admin_layout'); 
    }

    public function indexAction()
    {
		$layout = Zend_Layout::getMvcInstance();
	  	$layout->showBreadcrumbs = false;
		
		$this->view->pageTitle = 'LATEST NEWS';
		
		$news = new Application_Model_NewsMapper;
		
		$this->view->news = $news->fetchAll();
    }

    public function aboutUsAction()
    {
        // action body
    }

    public function privacyPolicyAction()
    {
        // action body
    }


}





