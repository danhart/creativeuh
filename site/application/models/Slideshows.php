<?php

class Application_Model_Slideshows extends Application_Model_DbTableModel
{
	protected $_page_label;
	
	public function setPageLabel($text)
	{
		$this->_page_label = $text;
		return $this;
	}

	public function getPageLabel()
	{
		return $this->_page_label;
	}

}

