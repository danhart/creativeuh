<?php

class Admin_Form_Courses extends Zend_Form
{

    public function isValid($data)
    {
    	/*if (isset($data['shipping']) && (bool) $data['shipping'] === true) {
    		$this->getElement('shipping-address')->setRequired();
    	}*/
    	return parent::isValid($data);
    }

    public function init()
    {

		$this->setDecorators(array(
            'FormErrors',
            'FormElements',
	    	array('HtmlTag', array('tag' => 'dl', 'class' => 'zend_form')),
            'Form'
        ));

        // Set the method for the display form to POST
        $this->setMethod('post');

		// Add the elements
	
		// For the title we should check if it already exists?
        $this->addElement('text', 'Title', array(
            'label'      => 'Course Title:',
            'required'   => true,
            'filters'    => array('StringTrim'),
	    	'validators' => array(
				// array('validator' => 'Alnum', 'options' => array('allowWhiteSpace' => true, 'messages' => array('notAlnum' => 'Course Title must only contain letters and numbers')), 'breakChainOnFailure' => true),
				array('validator' => 'Db_NoRecordExists', 'options' => array('table' => 'courses',
									     'field' => 'title',
									     'messages' => array('recordFound' => 'Sorry there is already a course named %value%!')
            )))
        ));

		$request = Zend_Controller_Front::getInstance()->getRequest();

		if($request->getActionName() == 'edit') {
                $courses = new Admin_Model_CoursesMapper();
                $course = $courses->find($request->getParam('id'));

                if($course->Title == $request->getPost('Title')) {
                        $this->Title->removeValidator('Db_NoRecordExists');
                }
        }

        $this->addElement('text', 'Subtitle', array(
            'label'      => 'Course Subtitle:',
            'filters'    => array('StringTrim')
        ));

		$this->addElement('file', 'Image', array(
	    	'label'	 => 'Course Image:',
	    	'required'   => true,
	    	'destination' => APPLICATION_PATH . '/../public/uploads',
	    	'validators' => array(
				array('validator' => 'Size', 'options' => array('max' => '2MB')),
				array('validator' => 'IsImage')
	    	),
	    	'filters' => array(
				array('filter' => 'Rename', 'options' => array('target' => APPLICATION_PATH . '/../public/uploads/course_image' . date('YmdHis')))
	    	)
		));

		if($request->getActionName() == 'edit') {
			$this->Image->setRequired(false);
        }

		$this->addElement('select', 'CategoryID', array(
	    	'label'	 => 'Select Category:',
	    	'required'	 => true,
	    	'validators' => array(
				array('validator' => 'Db_RecordExists', 'options' => array('table' => 'course_categories', 'field' => 'id')))
		));

	$categories = new Admin_Model_CategoriesMapper();

	// Should use fetchPairs instead of fetchAll
	foreach($categories->fetchAll() as $category) {
		$this->CategoryID->addMultiOption($category->id, $category->name);
	}

        $this->addElement('textarea', 'Aims', array(
            'label'      => 'Aims of the course:'
        ));

        $this->addElement('textarea', 'TargetAudience', array(
            'label'      => 'Who is it for?:'
        ));

        $this->addElement('textarea', 'Brief', array(
            'label'      => 'What does the course cover?:'
        ));

        $this->addElement('text', 'BookingURL', array(
            'label'      => 'Booking URL:',
	    'required'	 => true,
            'filters'    => array('StringTrim')
        ));

	$this->BookingURL->addValidator(new Core_Validate_Url());

	$courses = new Admin_Model_CoursesMapper();

	$this->addElement('multiselect', 'RelatedCourses', array(
		'label'  => 'Related Courses:',
		'MultiOptions' => $courses->fetchPairs()
	));

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
    }


}

