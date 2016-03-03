<?php

class Admin_CategoryController extends Zend_Controller_Action
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
	$categoryId = $this->_request->getParam('id');
        $categories = new Admin_Model_CategoriesMapper();
	$this->view->category = $categories->find($categoryId);
	$this->view->forAdults = ($this->view->category->AdultCategory) ? 'Yes' : 'No';
    }

    public function deleteAction()
    {
        $categories = new Admin_Model_CategoriesMapper();

        if ($this->getRequest()->isPost()) {
                $del = $this->getRequest()->getPost('del');
                if ($del == 'Yes') {
                        $id = $this->getRequest()->getPost('id');
                        $category = $categories->delete($id);
                }
                $this->_helper->redirector('index', 'index', 'admin');
        } else {
                $categoryId = $this->_request->getParam('id');
                $this->view->category = $categories->find($categoryId);
        }
    }

    public function editAction()
    {
		$categoryid = $this->getRequest()->getParam('id');
		$categories = new Admin_Model_CategoriesMapper();
		$form = new Admin_Form_Categories();
		
        if ($this->getRequest()->isPost()) {
            if ($form->isValid($this->getRequest()->getPost())) {
				// Values from form submit
                $category = new Admin_Model_Categories($form->getValues());

                // Id is set to the Model here so that mapper knows to update rather than insert
                $category->setId($categoryid);

                $categories->save($category);

                return $this->_helper->redirector('view', 'category', 'admin', array('id' => $categoryid));
            }
        } else {
            // I'd much rather pass this to my form constructor and deal with it there rather than here!
            if ($categoryid > 0) {
			// Values from database
			$category = $categories->find($categoryid);
				$form->populate(array(
						'Name'            => $category->getName(),
						'Image'           => $category->getImage(),
						'Description'     => $category->getDescription(),
						'AdultCategory'   => $category->getAdultCategory(),
						'MetaKeywords'    => $category->getMetaKeywords(),
						'MetaDescription' => $category->getMetaDescription()
				));
            }
        }

        $this->view->form = $form;
    }

    public function addAction()
    {
        $request = $this->getRequest();
        $form    = new Admin_Form_Categories();

        if ($this->getRequest()->isPost()) {
            if ($form->isValid($request->getPost())) {

                $category = new Admin_Model_Categories($form->getValues());

                $categories = new Admin_Model_CategoriesMapper();
                $categoryId = $categories->save($category);

                return $this->_helper->redirector('view', 'category', 'admin', array('id' => $categoryId));
            }
        }

        $this->view->form = $form;
    }


}









