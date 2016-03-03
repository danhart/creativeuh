<?php

class Admin_CourseController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */

    }

    public function indexAction()
    {

	// Create new Courses Mapper instance and use it to fetch all courses
        // $courses = new Admin_Model_CoursesMapper();

	// We have an array of Course Models here - one for each row.
	// $this->view->courses = $courses->fetchOne($course_id);
    }

    public function addAction()
    {

        $request = $this->getRequest();
        $form    = new Admin_Form_Courses();

        if ($request->isPost()) {
            if ($form->isValid($request->getPost())) {
				$course = new Admin_Model_Courses($form->getValues());
	
				// Save course
				$courses = new Admin_Model_CoursesMapper();
				$courseId = $courses->save($course);
	
				// Save Related Courses
				$relatedcourses = new Admin_Model_RelatedCoursesMapper();
				$relatedcourses->saveAll($courseId, $form->getValue('RelatedCourses'));
	
				// As we were successful in adding the course we redirect back to the view course action
                return $this->_helper->redirector('view', 'course', 'admin', array('id' => $courseId));
            }
        }
        $this->view->form = $form;
    }

    public function viewAction()
    {
        // action body
	$courseId = $this->_request->getParam('id');

	$courses = new Admin_Model_CoursesMapper();
	$this->view->course = $courses->find($courseId);

	$studyoptions = new Admin_Model_StudyOptionsMapper();
        $this->view->studyoptions = $studyoptions->fetchAll($courseId);

	$relatedcourses = new Admin_Model_RelatedCoursesMapper();
	$this->view->relatedcourses = $relatedcourses->fetchAll($courseId);
    }

    public function editAction()
    {
		$request = $this->getRequest();
		$courseId = $this->_request->getParam('id');
        $form    = new Admin_Form_Courses();
		$courses = new Admin_Model_CoursesMapper();
		$course = $courses->find($courseId);
		$relatedcourses = new Admin_Model_RelatedCoursesMapper();

		$form->submit->setLabel('Edit Course');

        if ($this->getRequest()->isPost()) {
            if ($form->isValid($request->getPost())) {
                $courseSave = new Admin_Model_Courses($form->getValues());

				// Id is set to the Model here so that mapper knows to update rather than insert
				$courseSave->setId($courseId);
                $courses->save($courseSave);

				$relatedcourses->saveAll($courseId, $form->getValue('RelatedCourses'));

                return $this->_helper->redirector('view', 'course', 'admin', array('id' => $courseId));
            }
        } else {
		// I'd much rather pass this to my form constructor and deal with it there rather than here!
			if ($courseId > 0) {
				$related_course_id_array = $relatedcourses->populateForm($courseId);

				$form->populate(array(
					'Title' 	=> $course->getTitle(),
					'Subtitle'	=> $course->getSubtitle(),
					'CategoryID'	=> $course->getCategoryID(),
					'Aims'		=> $course->getAims(),
					'TargetAudience' => $course->getTargetAudience(),
					'Brief'		=> $course->getBrief(),
					'BookingURL'	=> $course->getBookingURL(),
					'RelatedCourses'=> $related_course_id_array,
					'MetaKeywords'	=> $course->getMetaKeywords(),
					'MetaDescription' => $course->getMetaDescription()
				));
			}
		}
		
		$this->view->form = $form;
    }

    public function deleteAction()
    {
		$courses = new Admin_Model_CoursesMapper();
	
		if ($this->getRequest()->isPost()) {
			$del = $this->getRequest()->getPost('del');
			if ($del == 'Yes') {
				$id = $this->getRequest()->getPost('id');
				$course = $courses->delete($id);
			}
			$this->_helper->redirector('index', 'index', 'admin');
		} else {
			$courseId = $this->_request->getParam('id');
			$this->view->course = $courses->find($courseId);
		}
    }


}









