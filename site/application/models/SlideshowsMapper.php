<?php

class Application_Model_SlideshowsMapper
{
	protected $_dbTable;

	public function setDbTable($dbTable)
	{
		if (is_string($dbTable)) {
				$dbTable = new $dbTable();
		}
		if (!$dbTable instanceof Zend_Db_Table_Abstract) {
				throw new Exception('Invalid table data gateway provided');
		}
		$this->_dbTable = $dbTable;
		return $this;
	}

	public function getDbTable()
	{
		if (null === $this->_dbTable) {
				$this->setDbTable('Application_Model_DbTable_Slideshows');
		}
		return $this->_dbTable;
	}

	public function fetchRow($pageLabel)
	{
		$select = $this->getDbTable()->select()->where('page_label = ?', $pageLabel);
						   
		$row = $this->getDbTable()->fetchRow($select);

		if (count($row) == 0) {
			return; // no slideshows found
		}

		// Set the row to our Courses Model.
		$slideshow = new Application_Model_Slideshows();
		$slideshow->setId($row->id)
				  ->setPageLabel($row->page_label);

		return $slideshow;
		
	}

}

