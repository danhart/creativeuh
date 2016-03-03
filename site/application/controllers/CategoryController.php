<?php

class CategoryController extends Zend_Controller_Action
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
		
		// Obtain our category from the urlkey
		$categories = new Admin_Model_CategoriesMapper();
		$category = $categories->findByURLKey($urlkey);
		$this->view->category = $category;
		
		// Fetch all courses for this category
		$courses = new Admin_Model_CoursesMapper();
		$this->view->courses = $courses->fetchByCategory($category->getId());
		
		// No need for this in the view
		$this->view->pageTitle = $category->getName();
		$this->view->headTitle($this->view->pageTitle);
		
		$this->view->route = ($category->getAdultCategory()) ? 'adult_course_view' : 'young_course_view';
		
		/* $layout = Zend_Layout::getMvcInstance();
	  	$layout->showBreadcrumbs = true;
	 	$layout->showSlideshow = false; */
		$this->view->headMeta()->setName('Description', $category->getMetaDescription())
							   ->setName('Keywords', $category->getMetaKeywords());
		
    }

    public function viewNotAdultAction()
    {
		// Obtain our category from the urlkey
		$categoriesMapper = new Admin_Model_CategoriesMapper();
		$adultCategories = $categoriesMapper->fetchAll(0);
		
        // Fetch all courses for adults
		$courses = new Admin_Model_CoursesMapper();
		$this->view->courses = $courses->fetchByCategories($adultCategories);
    }

    public function listAdultAction()
    {
        $categories = new Admin_Model_CategoriesMapper();
		$adultCategories = $categories->fetchAll(1);
		
		$this->view->adultCategories = $adultCategories;
    }


}







