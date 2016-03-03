<?php

class Admin_Form_Slides extends Zend_Form
{

    public function init()
    {
        $this->addElement('file', 'FileName', array(
	    	'label'	 => 'Course Image:',
	    	'required'   => false,
	    	'destination' => APPLICATION_PATH . '/../public/uploads',
	    	'validators' => array(
				array('validator' => 'Size', 'options' => array('max' => '2MB')),
				array('validator' => 'IsImage')
	    	),
	    	'filters' => array(
				array('filter' => 'Rename', 'options' => array('target' => APPLICATION_PATH . '/../public/uploads/slide_image' . date('YmdHis')))
	    	)
		));
		
		$this->addElement('text', 'ColorCode', array(
            'label'      => 'Hex Color Code (from photoshop):',
            'filters'    => array('StringTrim'),
			'required'	 => true,
			'validators' => array(
				array('validator' => 'Hex'),
				array('validator' => 'StringLength', 'options' => array('max' => '6', 'min' => '6'))
        	)
	    ));
		
		$this->addElement('text', 'Href', array(
            'label'      => 'Slide Link:',
	    	'required'	 => false,
            'filters'    => array('StringTrim')
        ));

		// $this->Href->addValidator(new Core_Validate_Url());
		
		
		$this->addElement('submit', 'submit', array(
            'ignore'   => true,
	    	'label'    => 'Add Slide'
        ));
		
    }


}

