<?php

class Admin_Model_SlideshowsMapper extends Application_Model_SlideshowsMapper
{
	public function fetchAll()
	{
		$resultSet = $this->getDbTable()->fetchAll();

		$entries = array();

		foreach ($resultSet as $row) {
			$entry = new Application_Model_Slideshows();
			$entry->setId($row->id)
				  ->setPageLabel($row->page_label);
			$entries[] = $entry;
		}
		return $entries;
	}
	
	public function find($id)
	{
		$result = $this->getDbTable()->find($id);

		if (count($result) == 0) {
			return; // no course found
		}

		// I assume this narrows down the resultSet to just one row.
		$row = $result->current(); // Get the selected row
		
		$slideshow = new Application_Model_Slideshows();
		$slideshow->setId($row->id)
				  ->setPageLabel($row->page_label);
				  
		return $slideshow;
	}
	
	public function delete($slideshowid)
	{
		$where = $this->getDbTable()->getAdapter()->quoteInto('id = ?', $slideshowid);
		$this->getDbTable()->delete($where);
	}
	
	public function save(Application_Model_Slideshows $slideshow)
	{
		// Map each database entity to the passed instance of the Courses Model
		$data = array(
			'id' => $slideshow->getId(),
			'page_label' => $slideshow->getPageLabel()
		);
		
		unset($data['id']);

		// Insert and return the inserted row's id
		return $this->getDbTable()->insert($data);
	}
}

