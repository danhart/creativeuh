<?php

class Application_Model_NewsMapper
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
				$this->setDbTable('Application_Model_DbTable_News');
		}
		return $this->_dbTable;
	}

	public function fetchAll()
	{
		$select = $this->getDbTable()->select()->order('timestamp DESC');

		$select->from($this->getDbTable(),array(
			'id',
			'title',
			'url_key',
			'subtitle',
			'image',
			'content',
			'timestamp' => new Zend_Db_Expr('UNIX_TIMESTAMP(timestamp)')
		));

		$resultSet = $this->getDbTable()->fetchAll($select);

		$entries = array();

		foreach ($resultSet as $row) {
			$entry = new Application_Model_News();
			$entry->setId($row->id)
				  ->setTitle($row->title)
				  ->setURLKey($row->url_key)
				  ->setSubtitle($row->subtitle)
				  ->setImage($row->image)
				  ->setContent($row->content)
				  ->setTimestamp($row->timestamp);
			$entries[] = $entry;
		}
		return $entries;
	}
	
	public function fetchRow($URLKey)
	{
		$select  = $this->getDbTable()->select()->where('url_key = ?', $URLKey);
						   
		$row = $this->getDbTable()->fetchRow($select);

		if (count($row) == 0) {
			return; // no news
		}
		
		$news = new Application_Model_News();
		$news->setId($row->id)
			 ->setTitle($row->title)
			 ->setURLKey($row->url_key)
			 ->setSubtitle($row->subtitle)
			 ->setImage($row->image)
			 ->setContent($row->content)
		 	 ->setTimestamp($row->timestamp);

		return $news;
		
	}

}

