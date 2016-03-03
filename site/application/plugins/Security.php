<?php

class Application_Plugin_Security extends Zend_Controller_Plugin_Abstract
{
	public function preDispatch(Zend_Controller_Request_Abstract $request)
	{
		if ($request->getModuleName() == 'admin') {
			if (Zend_Auth::getInstance()->hasIdentity()) {
				// Logged in.. coolio
				die('in');
			} else {
				// Not logged in >:[
				
			}
		}
	}
}