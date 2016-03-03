<?php

class My_View_Helper_BodyClass extends Zend_View_Helper_Abstract
{

    public function bodyClass()
    {
		$request = Zend_Controller_Front::getInstance()->getRequest();
	
		$url = $request->getPathInfo();
	
		$classArray = array(
			$request->getModuleName(),
			$request->getModuleName() . '-' . $request->getControllerName(),
			$request->getModuleName() . '-' . $request->getControllerName() . '-' . $request->getActionName()
		);
	
		return implode(' ', $classArray);
    }

}
