<?php

class Admin_NewsController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        // action body
    }

    public function listAction()
    {
        $news = new Application_Model_NewsMapper;
		$this->view->news = $news->fetchAll();
    }

    public function viewAction()
    {
        $id = $this->_request->getParam('id');
		
        $news = new Admin_Model_NewsMapper;
		$this->view->news = $news->find($id);
		
		if ($this->view->news === NULL) throw new Zend_Controller_Action_Exception('This news article doesn\'t exist',404);
    }

    public function addAction()
    {
        $request = $this->getRequest();
        $form    = new Admin_Form_News();

        if ($this->getRequest()->isPost()) {
            if ($form->isValid($request->getPost())) {

                $article = new Application_Model_News($form->getValues());

                $news = new Admin_Model_NewsMapper();
                $articleId = $news->save($article);

                return $this->_helper->redirector('view', 'news', 'admin', array('id' => $articleId));
            }
        }

        $this->view->form = $form;
    }

    public function editAction()
    {
        $articleid = $this->getRequest()->getParam('id');
		$news = new Admin_Model_NewsMapper();
		$form = new Admin_Form_News();
		
        if ($this->getRequest()->isPost()) {
            if ($form->isValid($this->getRequest()->getPost())) {
				// Values from form submit
                $article = new Application_Model_News($form->getValues());

                // Id is set to the Model here so that mapper knows to update rather than insert
                $article->setId($articleid);

                $news->save($article);

                return $this->_helper->redirector('view', 'news', 'admin', array('id' => $articleid));
            }
        } else {
            // I'd much rather pass this to my form constructor and deal with it there rather than here!
            if ($articleid > 0) {
			// Values from database
			$article = $news->find($articleid);
				$form->populate(array(
						'Title'           => $article->getTitle(),
						'Image'           => $article->getImage(),
						'Subtitle'        => $article->getSubtitle(),
						'Content'         => $article->getContent()
				));
            }
        }

        $this->view->form = $form;
    }

    public function deleteAction()
    {
        $news = new Admin_Model_NewsMapper();
	
		if ($this->getRequest()->isPost()) {
			$del = $this->getRequest()->getPost('del');
			if ($del == 'Yes') {
				$id = $this->getRequest()->getPost('id');
				$news->delete($id);
			}
			$this->_helper->redirector('list', 'news', 'admin');
		} else {
			$articleId = $this->_request->getParam('id');
			$this->view->article = $news->find($articleId);
		}
    }


}











