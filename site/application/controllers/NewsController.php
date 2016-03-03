<?php

class NewsController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        // action body
    }

    public function viewAction()
    {
		$urlkey = $this->_request->getParam('urlkey');
		
        $news = new Application_Model_NewsMapper;
		$this->view->news = $news->fetchRow($urlkey);
		
		if ($this->view->news === NULL) throw new Zend_Controller_Action_Exception('This news article doesn\'t exist',404);
		
		$this->view->pageTitle = $this->view->news->getTitle();
		$this->view->headTitle($this->view->pageTitle);
		
		// Add this page to our navigation so that the breadcrumbs appear.
		$newsNav = $this->view->navigation()->findOneBy('label', 'Latest News');
			$newsNav->addPage(new Zend_Navigation_Page_Mvc(array(
				'label'		 => $this->view->news->getTitle(),
				'module'     => 'default',
				'controller' => 'news',
				'action'     => 'view',
				'visible'	 => false,
				'params'	 => array(
					'urlkey' => $this->view->news->getURLKey()
				),
				'route'      => 'default'
		)));
    }


}



