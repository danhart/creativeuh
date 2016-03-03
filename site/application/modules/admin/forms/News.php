<?php

class Admin_Form_News extends Zend_Form
{

    public function init()
    {
        $request = Zend_Controller_Front::getInstance()->getRequest();
	
		$this->setDecorators(array(
			'FormErrors',
			'FormElements',
			array('HtmlTag', array('tag' => 'dl', 'class' => 'zend_form')),
			'Form'
		));
		
		$this->setMethod('post');
	
		$this->addElement('text', 'Title', array(
			'label'      => 'Article Title:',
			'required'   => true,
			'filters'    => array('StringTrim'),
			'validators' => array(
				array('validator' => 'Db_NoRecordExists', 'options' => array('table' => 'news',
																			 'field' => 'title',
																			 'messages' => array('recordFound' => 'Sorry there is already a news article named %value%!')
			)))
		));
		
		if($request->getActionName() == 'edit') {
			$newsMapper = new Admin_Model_NewsMapper();
			$news = $newsMapper->find($request->getParam('id'));

			if($news->Title == $request->getPost('Title')) {
				$this->Title->removeValidator('Db_NoRecordExists');
			}
        }
		
		$this->addElement('text', 'Subtitle', array(
			'label'      => 'Subtitle:',
			'filters'    => array('StringTrim')
		));
		
		$this->addElement('file', 'Image', array(
			'label'	 => 'Article Image:',
			'required'   => true,
			'destination' => APPLICATION_PATH . '/../public/uploads',
			'validators' => array(
				array('validator' => 'Size', 'options' => array('max' => '2MB')),
				array('validator' => 'IsImage')
			),
			'filters' => array(
				array('filter' => 'Rename', 'options' => array('target' => APPLICATION_PATH . '/../public/uploads/news_image' . date('YmdHis')))
			)
		));
		
		if($request->getActionName() == 'edit') {
			$this->Image->setRequired(false);
		}
		
		$this->addElement('textarea', 'Content', array(
            'label'      => 'Article Content:'
        ));
		
		// Add the submit button
		$this->addElement('submit', 'submit', array(
			'ignore'   => true,
			'label'    => 'Add Article'
		));
	
		if($request->getActionName() == 'edit') {
			$this->submit->setLabel('Edit Article');
		}
		
    }


}

