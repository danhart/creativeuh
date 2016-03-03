<?php

class Application_Model_SlidesMapper
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
				$this->setDbTable('Application_Model_DbTable_Slides');
		}
		return $this->_dbTable;
	}

	public function fetchAll($slideshowId)
	{
		$select = $this->getDbTable()->select()->where('slideshow_id = ?', $slideshowId)
											   ->order('slide_order ASC');

		$resultSet = $this->getDbTable()->fetchAll($select);

		$entries = array();

		foreach ($resultSet as $row) {
			$entry = new Application_Model_Slides();
			$entry->setId($row->id)
				  ->setSlideShowId($row->slideshow_id)
				  ->setFileName($row->file_name)
				  ->setColorCode($row->color_code)
				  ->setHref($row->href)
				  ->setOriginalFileName($row->original_file_name)
				  ->setSlideOrder($row->slide_order);
			$entries[] = $entry;
		}
		return $entries;
	}

}

