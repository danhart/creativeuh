<?php

class Admin_StudyOptionController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
    }

    public function addAction()
    {
        $form    = new Admin_Form_StudyOptions();
		$courseId = $this->_request->getParam('id');

        if ($this->getRequest()->isPost()) {
            if ($form->isValid($this->getRequest()->getPost())) {

            	$studyoption = new Admin_Model_StudyOptions($form->getValues());
				$studyoption->setCourseId($courseId);

				// Save study option
                $studyoptions = new Admin_Model_StudyOptionsMapper();
                $studyoptions->save($studyoption);

                return $this->_helper->redirector('view', 'course', 'admin', array('id' => $courseId));
            }
        }

		$this->view->form = $form;
    }

    public function deleteAction()
    {
		$studyoptions = new Admin_Model_StudyOptionsMapper();
	
		if ($this->getRequest()->isPost()) {
			$del = $this->getRequest()->getPost('del');
			$id = $this->getRequest()->getPost('id');
			$courseId = $studyoptions->find($id)->getCourseId();
			
			if ($del == 'Yes') {
				$studyoptions->delete($id);
			}
			$this->_helper->redirector('view', 'course', 'admin', array('id' => $courseId));
		} else {
				$studyoptionId = $this->_request->getParam('studyoptionid');
				$this->view->studyoption = $studyoptions->find($studyoptionId);
			
		}
	}
	
	public function editAction()
    {
        $form = new Admin_Form_StudyOptions();
		$studyOptions = new Admin_Model_StudyOptionsMapper();
		$studyOptionId = $this->_request->getParam('id');
		$courseId = $this->_request->getParam('courseid');
		
		$form->submit->setLabel('Edit Study Option');

        if ($this->getRequest()->isPost()) {
            if ($form->isValid($this->getRequest()->getPost())) {

            	$studyOption = new Admin_Model_StudyOptions($form->getValues());
				$studyOption->setId($studyOptionId);
				$studyOption->setCourseId($courseId);

				// Save study option
                $studyOptions->save($studyOption);

                return $this->_helper->redirector('view', 'course', 'admin', array('id' => $courseId));
            }
        } else {
            // I'd much rather pass this to my form constructor and deal with it there rather than here!
            if ($studyOptionId > 0) {
				// Values from database
				$studyOption = $studyOptions->find($studyOptionId);
				$form->populate(array(
						'Semester'	=> $studyOption->getSemester(),
						'Days'		=> $studyOption->getDays(),
						'Dates'		=> $studyOption->getDates(),
						'Times'		=> $studyOption->getTimes(),
						'Duration'	=> $studyOption->getDuration(),
						'Fee'		=> $studyOption->getFee(),
						'Code'		=> $studyOption->getCode(),
						'Location'	=> $studyOption->getLocation()
				));
            }
        }

		$this->view->form = $form;
    }


}


