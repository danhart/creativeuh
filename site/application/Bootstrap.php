<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{

	protected function _initDoctype() 
	{
        $this->bootstrap('view');
        $view = $this->getResource('view');
		$view->setEncoding('UTF-8');
        $view->doctype('HTML5');
		
		$view->headMeta()->appendHttpEquiv('Content-Type', 'text/html;charset=utf-8')
						 ->appendName('Author', 'Dan Hart - danhart.co.uk')
                         ->appendName('viewport', 'width=1024')
						 ->appendName('Description', 'Short courses and training for adults and young people provided by The University of Hertfordshire.')
                         ->appendName('Keywords', 'Creative Innovation & Training, The University of Hertfordshire, School of Creative Arts');
						 
		$view->headTitle()->setSeparator(' - ');
	}

	protected function _initRoutes() {
		$this->bootstrap('frontController');
		$frontController = $this->getResource('frontController');
		$router = $frontController->getRouter();
		
		$router->addRoute(
			'adult_course_view',
			new Zend_Controller_Router_Route('short-courses-and-training/:categorykey/:urlkey', array('module' => 'default', 'controller' => 'course', 'action' => 'view', 'categorykey' => NULL, 'urlkey' => NULL))
		);
		
		$router->addRoute(
			'young_course_view',
			new Zend_Controller_Router_Route('young-people/:categorykey/:urlkey', array('module' => 'default', 'controller' => 'course', 'action' => 'view', 'categorykey' => NULL, 'urlkey' => NULL))
		);
		
		$router->addRoute(
			'course_view',
			new Zend_Controller_Router_Route('courses/:urlkey', array('module' => 'default', 'controller' => 'course', 'action' => 'view', 'urlkey' => NULL))
		);
		
		$router->addRoute(
			'adult_category_view',
			new Zend_Controller_Router_Route('short-courses-and-training/:urlkey', array('module' => 'default', 'controller' => 'category', 'action' => 'view', 'urlkey' => NULL))
		);
		
		$router->addRoute(
			'young_category_view',
			new Zend_Controller_Router_Route('young-people/:urlkey', array('module' => 'default', 'controller' => 'category', 'action' => 'view', 'urlkey' => NULL))
		);
		
		$router->addRoute(
			'short_courses_and_training',
			new Zend_Controller_Router_Route('short-courses-and-training', array('module' => 'default', 'controller' => 'category', 'action' => 'list-adult'))
		);
		
		$router->addRoute(
			'young_people',
			new Zend_Controller_Router_Route('young-people', array('module' => 'default', 'controller' => 'category', 'action' => 'view-not-adult'))
		);
		
		$router->addRoute(
			'news_view',
			new Zend_Controller_Router_Route('news/:urlkey', array('module' => 'default', 'controller' => 'news', 'action' => 'view', 'urlkey' => NULL))
		);
		
		$router->addRoute(
			'news',
			new Zend_Controller_Router_Route('news', array('module' => 'default', 'controller' => 'index', 'action' => 'index'))
		);
	}

	protected function _initLayoutHelpers()
	{
		// Zend_Layout::startMvc(); Don't think this is needed?
		Zend_Controller_Action_HelperBroker::addPath(APPLICATION_PATH .'/controllers/helpers');

		// We can use this to mimic a $this->_helper->layoutloader() request that normally happens in a controller
		$layoutloader = Zend_Controller_Action_HelperBroker::getStaticHelper('LayoutLoader');
		Zend_Controller_Action_HelperBroker::addHelper($layoutloader);
		
		$showbreadcrumbs = Zend_Controller_Action_HelperBroker::getStaticHelper('ShowBreadcrumbs');
		Zend_Controller_Action_HelperBroker::addHelper($showbreadcrumbs);

		// Old method
		// Zend_Controller_Action_HelperBroker::addHelper(new Zend_Controller_Action_Helper_LayoutLoader());
	}

	protected function _initViewHelpers()
	{
		$this->bootstrap('view');
        $view = $this->getResource('view');

		$view->addHelperPath(APPLICATION_PATH . '/views/helpers', 'My_View_Helper');

		$view->addHelperPath(APPLICATION_PATH . '/../library/Core/View/Helper', 'Core_View_Helper');
	}
	
	protected function _initControllerPlugins() {
		
		$loader = new Zend_Loader_PluginLoader(array('Application_Plugin' => APPLICATION_PATH . '/plugins'));
		
		// $loader->load('LoadNav');
		
		$this->bootstrap('frontController');
		
		$front = $this->getResource('frontController');
		
		// Register Security (Auth/ACL)
		$front->registerPlugin(new Application_Plugin_Security());
		
		// Register LoadNav
		$front->registerPlugin(new Application_Plugin_LoadNav());
		
		// Register SlideShow
		$front->registerPlugin(new Application_Plugin_SlideShow());
		
	}

}
