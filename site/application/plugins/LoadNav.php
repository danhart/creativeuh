<?php

class Application_Plugin_LoadNav extends Zend_Controller_Plugin_Abstract
{
	public function preDispatch(Zend_Controller_Request_Abstract $request)
	{
		$view = Zend_Controller_Front::getInstance()->getParam('bootstrap')->getResource('view');
		$router = Zend_Controller_Front::getInstance()->getRouter();

		$navConfig = new Zend_Config_Xml(APPLICATION_PATH . '/configs/navigation.xml', 'nav');
		$navAdminConfig = new Zend_Config_Xml(APPLICATION_PATH . '/configs/navigation-admin.xml', 'nav');

		$navigation = new Zend_Navigation($navConfig);
		$navigationAdmin = new Zend_Navigation($navAdminConfig);

		// Zend_Registry::set(Zend_Navigation, $navigation);
		Zend_Registry::set('NavigationAdmin', $navigationAdmin);

		$view->navigation($navigation);

		$shortCourses = $navigation->findOneBy('label', 'Short Courses & Training');
		$youngPeople = $navigation->findOneBy('label', 'Young People');
		
		$categories = new Admin_Model_CategoriesMapper();
		$adultCategories = $categories->fetchAll(1);
		$youngCategories = $categories->fetchAll(0);

		$coursesMapper = new Admin_Model_CoursesMapper();
		$courses = $coursesMapper->fetchAll();

		// Add all short course categories
		foreach($adultCategories as $category) {
			$shortCourses->addPage(new Zend_Navigation_Page_Mvc(array(
				'label'		 => $category->getName(),
				'module'     => 'default',
				'controller' => 'category',
				'action'     => 'view',
				'params'	 => array(
					'urlkey' => $category->getURLKey()
				),
				'route'      => 'adult_category_view'
			)));
		}
		
		// Add all young people's categories
		foreach($youngCategories as $category) {
			$youngPeople->addPage(new Zend_Navigation_Page_Mvc(array(
				'label'		 => $category->getName(),
				'module'     => 'default',
				'controller' => 'category',
				'action'     => 'view',
				'params'	 => array(
					'urlkey' => $category->getURLKey()
				),
				'route'      => 'young_category_view'
			)));
		}
		
		// Add all courses to the correct categories. Needed for breadcrumbs and routes
		// We could actually do this in the course view controller instead. E.g. just add the page that we are currently viewing? Although not good for a sitemap..
		foreach($courses as $course) {
			$category = $navigation->findOneBy('label', $course->getCategoryName());
			$category->addPage(new Zend_Navigation_Page_Mvc(array(
				'label'		 => $course->getTitle(),
				'module'     => 'default',
				'controller' => 'course',
				'action'     => 'view',
				'visible'	 => false,
				'params'	 => array(
					'urlkey' => $course->getURLKey()
				),
				'route'      => 'default'
			)));
		}
	}
}