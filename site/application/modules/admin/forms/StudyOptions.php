<?php

class Admin_Form_StudyOptions extends Zend_Form
{

    public function init()
    {
	$this->setDecorators(array(
            'FormErrors',
            'FormElements',
            array('HtmlTag', array('tag' => 'dl', 'class' => 'zend_form')),
            'Form'
        ));

	$this->setMethod('post');

	$this->addElement('select', 'Semester', array(
            'label'      => 'Semester:',
	    'required'	 => true,
            'MultiOptions' => array('A' => 'A', 'B' => 'B', 'C' => 'C')
        ));

	$this->addElement('text', 'Days', array(
            'label'      => 'Days:',
            'filters'    => array('StringTrim')
        ));

	$this->addElement('text', 'Dates', array(
            'label'      => 'Dates:',
            'filters'    => array('StringTrim')
        ));

	$this->addElement('text', 'Times', array(
            'label'      => 'Times:',
            'filters'    => array('StringTrim')
        ));

	$this->addElement('text', 'Duration', array(
            'label'      => 'Duration:',
            'filters'    => array('StringTrim')
        ));

	$this->addElement('text', 'Fee', array(
            'label'      => 'Fee:',
            'filters'    => array('StringTrim'),
	    'validators' => array(
		array('validator' => 'Float')
	    )
        ));

	$this->addElement('text', 'Code', array(
            'label'      => 'Course Code:',
	    'required'	 => true,
            'filters'    => array('StringTrim')
        ));

	$this->addElement('text', 'Location', array(
            'label'      => 'Location:',
            'filters'    => array('StringTrim')
        ));

	// Add the submit button
        $this->addElement('submit', 'submit', array(
            'ignore'   => true,
            'label'    => 'Add Study Option',
        ));

    }

}

