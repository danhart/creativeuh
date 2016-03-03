<?php

class Admin_SlideshowController extends Zend_Controller_Action
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
		$this->view->headScript()->prependFile('/js/jquery-ui-1.8.16.custom.min.js');
		
		$slideshowId = $this->_request->getParam('id');
		
		$slides = new Admin_Model_SlidesMapper;
		$this->view->slides = $slides->fetchAll($slideshowId);
		
		$slideshows = new Admin_Model_SlideshowsMapper;
		$this->view->slideshow = $slideshows->find($slideshowId);
    }

    public function listAction()
    {
        $slideshows = new Admin_Model_SlideshowsMapper;
		$this->view->slideshows = $slideshows->fetchAll();
    }

    public function sortAction()
    {
		// Remove the normal HTML response
        $this->_helper->layout()->disableLayout();
    	$this->_helper->viewRenderer->setNoRender(true);
		
		$slideshowId = $this->_request->getParam('id');
		
		$slides = new Admin_Model_SlidesMapper;
		$slides->reorder($this->getRequest()->getPost('slide'));
    }

    public function deleteSlideAction()
    {
		$slideshowid = $this->_request->getParam('id');
		
        $slideId = $this->_request->getParam('slideid');
		
		$slides = new Admin_Model_SlidesMapper;
		$slides->delete($slideId);
		
		return $this->_helper->redirector('view', 'slideshow', 'admin', array('id' => $slideshowid));
    }

    public function deleteAction()
    {
		$slideshows = new Admin_Model_SlideshowsMapper;
	
		if ($this->getRequest()->isPost()) {
			$del = $this->getRequest()->getPost('del');
			if ($del == 'Yes') {
				$slideshowid = $this->getRequest()->getPost('id');
				$slideshows->delete($slideshowid);
			}
			$this->_helper->redirector('list', 'slideshow', 'admin');
		} else {
			$slideshowid = $this->_request->getParam('id');
			$this->view->slideshow = $slideshows->find($slideshowid);
		}
		
    }

    public function addAction()
    {
        $request = $this->getRequest();
        $form    = new Admin_Form_Slideshows();

        if ($request->isPost()) {
            if ($form->isValid($request->getPost())) {
				$slideshow = new Application_Model_Slideshows($form->getValues());
	
				// Save course
				$slideshows = new Admin_Model_SlideshowsMapper();
				$slideshowid = $slideshows->save($slideshow);
	
				// As we were successful in adding the course we redirect back to the view course action
                return $this->_helper->redirector('view', 'slideshow', 'admin', array('id' => $slideshowid));
            }
        }
        $this->view->form = $form;
    }

    public function addSlideAction()
    {
        $request = $this->getRequest();
        $form    = new Admin_Form_Slides();
		
		$slideshowid = $this->_request->getParam('id');
		
		if ($request->isPost()) {
            if ($form->isValid($request->getPost())) {
				$slide = new Application_Model_Slides($form->getValues());
				$slide->setSlideShowId($slideshowid);
	
				// Save course
				$slides = new Admin_Model_SlidesMapper();
				$slideid = $slides->save($slide);
	
				// As we were successful in adding the course we redirect back to the view course action
                return $this->_helper->redirector('view', 'slideshow', 'admin', array('id' => $slideshowid));
            }
        }
        $this->view->form = $form;
    }


}















