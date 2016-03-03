<?php

class Admin_IndexController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
		// $this->view->test = $this->getRequest()->getParam('moo');
		// $this->_forward('list'); Automatically forward to the list method
	
		// Add the css for the courses list table
		$this->view->headLink()->appendStylesheet('/css/demo_table_jui.css')
					   		   ->appendStylesheet('/css/jquery-ui-1.8.4.custom.css');
	
		// Add the javascript for the courses list table
        $this->view->headScript()->prependFile('/js/jquery.dataTables.js');

        // Create new Courses Mapper instance and use it to fetch all courses
        $courses = new Admin_Model_CoursesMapper();

        // We have an array of Course Models here - one for each row.
        $this->view->courses = $courses->fetchAll();

		$categories = new Admin_Model_CategoriesMapper();
		$this->view->categories = $categories->fetchAll();

    }


}

