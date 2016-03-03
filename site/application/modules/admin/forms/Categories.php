<?php

class Admin_Form_Categories extends Zend_Form
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
	
		$this->addElement('text', 'Name', array(
			'label'      => 'Category Name:',
			'required'   => true,
			'filters'    => array('StringTrim'),
			'validators' => array(
				array('validator' => 'Db_NoRecordExists', 'options' => array('table' => 'course_categories',
																			 'field' => 'name',
																			 'messages' => array('recordFound' => 'Sorry there is already a category named %value%!')
			)))
		));
		
		$this->addElement('file', 'Image', array(
			'label'	 => 'Category Image:',
			'required'   => true,
			'destination' => APPLICATION_PATH . '/../public/uploads',
			'validators' => array(
				array('validator' => 'Size', 'options' => array('max' => '2MB')),
				array('validator' => 'IsImage')
			),
			'filters' => array(
				array('filter' => 'Rename', 'options' => array('target' => APPLICATION_PATH . '/../public/uploads/category_image' . date('YmdHis')))
			)
		));
	
		if($request->getActionName() == 'edit') {
			$this->Image->setRequired(false);
		}
		
		$this->addElement('text', 'Description', array(
			'label'      => 'Course Description:',
			'filters'    => array('StringTrim')
		));
	
		$this->addElement('select', 'AdultCategory', array(
			'label'      => 'Is this for Adults?:',
			'required'   => true,
			'MultiOptions' => array('1' => 'Yes', '0' => 'No')
		));
	
		if($request->getActionName() == 'edit') {
			$categories = new Admin_Model_CategoriesMapper();
			$category = $categories->find($request->getParam('id'));
	
			if($category->Name == $request->getPost('Name')) {
				$this->Name->removeValidator('Db_NoRecordExists');
			}
		}
	
	
		$this->addElement('text', 'MetaKeywords', array(
			'label'      => 'Meta Keywords: (seperate with commas)',
			'filters'    => array('StringTrim')
		));
	
		$this->addElement('textarea', 'MetaDescription', array(
			'label'      => 'Meta Description:'
		));
	
		// Add the submit button
		$this->addElement('submit', 'submit', array(
			'ignore'   => true,
			'label'    => 'Add Course'
		));
	
		if($request->getActionName() == 'edit') {
			$this->submit->setLabel('Edit Category');
		}
    }
}

