<?php

class Admin_Form_Slideshows extends Zend_Form
{

    public function init()
    {
        // Set the method for the display form to POST
        $this->setMethod('post');
		
		// For the title we should check if it already exists?
        $this->addElement('text', 'PageLabel', array(
            'label'      => 'Page Label:',
            'required'   => true,
            'filters'    => array('StringTrim'),
	    	'validators' => array(
				array('validator' => 'Db_NoRecordExists', 'options' => array(
					'table' => 'slideshows',
					'field' => 'page_label',
					'messages' => array('recordFound' => 'Sorry there is already a slideshow named %value%!')
            )))
        ));
		
		// Add the submit button
        $this->addElement('submit', 'submit', array(
            'ignore'   => true,
	    	'label'    => 'Add Slideshow'
        ));
    }


}

