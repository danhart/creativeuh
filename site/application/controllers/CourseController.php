<?php

class CourseController extends Zend_Controller_Action
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
        // action body
		$urlkey = $this->_request->getParam('urlkey');
		
		// Fetch all courses for this category
		$courses = new Admin_Model_CoursesMapper();
		$this->view->course = $courses->fetchRow($urlkey);
		
		$studyoptions = new Admin_Model_StudyOptionsMapper();
        $this->view->studyoptions = $studyoptions->fetchAll($this->view->course->getId());

		$relatedcourses = new Admin_Model_RelatedCoursesMapper();
		$this->view->relatedcourses = $relatedcourses->fetchAll($this->view->course->getId());
		
		// No need for this in the view
		$this->view->pageTitle = $this->view->course->getTitle();
		$this->view->headTitle($this->view->pageTitle);
		$this->view->headMeta()->setName('Description', $this->view->course->getMetaDescription())
							   ->setName('Keywords', $this->view->course->getMetaKeywords());
    }

    public function searchAction()
    {
        if ($this->getRequest()->isPost()) {
			$query = $this->getRequest()->getPost('q');
			$this->view->query = $query;
			if(!empty($query)) {
				$courses = new Admin_Model_CoursesMapper();
				$this->view->results = $courses->searchAll($query);
			}
		}
    }


}





