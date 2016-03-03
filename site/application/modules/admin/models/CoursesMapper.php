<?php

class Admin_Model_CoursesMapper
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
			$this->setDbTable('Admin_Model_DbTable_Courses');
		}
		return $this->_dbTable;
	}

	public function delete($id)
	{
		// Delete the image
		$course = $this->find($id);
		unlink(APPLICATION_PATH . '/../public/uploads/' . $course->Image);

		$where = $this->getDbTable()->getAdapter()->quoteInto('id = ?', $id);
		$this->getDbTable()->delete($where);
	}

	// Save method also works for update :)
	public function save(Admin_Model_Courses $courses)
	{
		$urlfilter = new Core_Filter_UrlKey();

		// Map each database entity to the passed instance of the Courses Model
		$data = array(
			'id' => $courses->getId(),
			'title' => $courses->getTitle(),
			'category_id' => $courses->getCategoryID(),
			'url_key' => $urlfilter->filter($courses->getTitle()),
			'subtitle' => $courses->getSubtitle(),
			'aims' => $courses->getAims(),
			'target_audience' => $courses->getTargetAudience(),
			'brief' => $courses->getBrief(),
			'booking_url' => $courses->getBookingURL(),
			'image' => $courses->getImage(),
			'meta_keywords' => $courses->getMetaKeywords(),
			'meta_description' => $courses->getMetaDescription()
		);

		// If the passed Courses Model instance has no Id set then insert, else update
		if (($id = $courses->getId()) === null) {
			unset($data['id']);

			// Insert and return the inserted row's id
			return $this->getDbTable()->insert($data);

		} else {
			// So an update can be performed without changing the image file
			$image = $courses->getImage();
			if (empty($image)) {
				unset($data['image']);
			} else {
				// We have a new image so we should unlink the old one
				unlink(APPLICATION_PATH . '/../public/uploads/' . $this->find($id)->Image);
			}

			$this->getDbTable()->update($data, array('id = ?' => $id));
		}
	}

	public function find($id)
	{
		$result = $this->getDbTable()->find($id);

		if (count($result) == 0) {
			return; // no course found
		}

		// I assume this narrows down the resultSet to just one row.
		$row = $result->current(); // Get the selected row

		$category = $row->findParentRow('Admin_Model_DbTable_Categories');

		// Set the row to our Courses Model.
		$course = new Admin_Model_Courses();
		$course->setId($row->id)
			->setTitle($row->title)
			->setCategoryID($row->category_id)
			->setCategoryName($category->name)
			->setURLKey($row->url_key)
			->setSubtitle($row->subtitle)
			->setAims($row->aims)
			->setTargetAudience($row->target_audience)
			->setBrief($row->brief)
			->setBookingURL($row->booking_url)
			->setImage($row->image)
			->setMetaKeywords($row->meta_keywords)
			->setMetaDescription($row->meta_description);

		return $course;

	}
	
	public function fetchRow($URLKey)
	{
		$select  = $this->getDbTable()->select()->where('url_key = ?', $URLKey);
						   
		$row = $this->getDbTable()->fetchRow($select);

		if (count($row) == 0) {
			return; // no course found
		}

		// I assume this narrows down the resultSet to just one row.
		// $row = $result->current(); // Get the selected row

		$category = $row->findParentRow('Admin_Model_DbTable_Categories');

		// Set the row to our Courses Model.
		$course = new Admin_Model_Courses();
		$course->setId($row->id)
			->setTitle($row->title)
			->setCategoryID($row->category_id)
			->setCategoryName($category->name)
			->setURLKey($row->url_key)
			->setSubtitle($row->subtitle)
			->setAims($row->aims)
			->setTargetAudience($row->target_audience)
			->setBrief($row->brief)
			->setBookingURL($row->booking_url)
			->setImage($row->image)
			->setMetaKeywords($row->meta_keywords)
			->setMetaDescription($row->meta_description);

		return $course;
		
	}

	public function fetchPairs()
	{
		return $this->getDbTable()->getAdapter()->fetchPairs('SELECT id, title FROM courses ORDER BY title ASC');
	}

	public function fetchByCategory($categoryID)
	{
		$select = $this->getDbTable()->select()->where('category_id = ?', $categoryID)
											   ->order('title ASC');
		
		$resultSet = $this->getDbTable()->fetchAll($select);

		$entries = array();

		foreach ($resultSet as $row) {

			$category = $row->findParentRow('Admin_Model_DbTable_Categories');

			// Create an array of Courses Models for each row in the set
			$entry = new Admin_Model_Courses();
			$entry->setId($row->id)
				  ->setTitle($row->title)
				  ->setCategoryID($row->category_id)
				  ->setCategoryName($category->name)
				  ->setURLKey($row->url_key)
				  ->setSubtitle($row->subtitle)
				  ->setAims($row->aims)
				  ->setTargetAudience($row->target_audience)
				  ->setBrief($row->brief)
				  ->setBookingURL($row->booking_url)
				  ->setImage($row->image)
				  ->setMetaKeywords($row->meta_keywords)
				  ->setMetaDescription($row->meta_description);
			$entries[] = $entry;
		}
		return $entries;
	}
	
	public function fetchByCategories($categories)
	{
		foreach ($categories as $category) {
			$inArray[] = $category->getId();
		}
		
		$select = $this->getDbTable()->select()->where('category_id IN (?)', $inArray)
											   ->order('title ASC');
		
		$resultSet = $this->getDbTable()->fetchAll($select);

		$entries = array();

		foreach ($resultSet as $row) {

			$category = $row->findParentRow('Admin_Model_DbTable_Categories');

			// Create an array of Courses Models for each row in the set
			
			// You could apply an entire category class to an array entry. e.g. ->setCategory($category_entry);
			$entry = new Admin_Model_Courses();
			$entry->setId($row->id)
				  ->setTitle($row->title)
				  ->setCategoryID($row->category_id)
				  ->setCategoryName($category->name)
				  ->setCategoryURLKey($category->url_key)
				  ->setURLKey($row->url_key)
				  ->setSubtitle($row->subtitle)
				  ->setAims($row->aims)
				  ->setTargetAudience($row->target_audience)
				  ->setBrief($row->brief)
				  ->setBookingURL($row->booking_url)
				  ->setImage($row->image)
				  ->setMetaKeywords($row->meta_keywords)
				  ->setMetaDescription($row->meta_description);
			$entries[] = $entry;
		}
		return $entries;
	}

	public function fetchAll()
	{
		$resultSet = $this->getDbTable()->fetchAll();

		$entries = array();

		foreach ($resultSet as $row) {

			$category = $row->findParentRow('Admin_Model_DbTable_Categories');

			// Create an array of Courses Models for each row in the set
			$entry = new Admin_Model_Courses();
			$entry->setId($row->id)
				  ->setTitle($row->title)
				  ->setCategoryID($row->category_id)
				  ->setCategoryName($category->name)
				  ->setURLKey($row->url_key)
				  ->setSubtitle($row->subtitle)
				  ->setAims($row->aims)
				  ->setTargetAudience($row->target_audience)
				  ->setBrief($row->brief)
				  ->setBookingURL($row->booking_url)
				  ->setImage($row->image)
				  ->setMetaKeywords($row->meta_keywords)
				  ->setMetaDescription($row->meta_description);
			$entries[] = $entry;
		}
		return $entries;
	}
	
	public function searchAll($searchTerm)
	{
		// Should switch this out for a full lucene search at some point...
		
		$select = $this->getDbTable()->select()->where('title LIKE ?', '%' . $searchTerm . '%')
											   ->orWhere('subtitle LIKE ?', '%' . $searchTerm . '%')
											   ->orWhere('aims LIKE ?', '%' . $searchTerm . '%')
											   ->orWhere('target_audience LIKE ?', '%' . $searchTerm . '%')
											   ->orWhere('brief LIKE ?', '%' . $searchTerm . '%')
											   ->orWhere('meta_keywords LIKE ?', '%' . $searchTerm . '%')
											   ->orWhere('meta_description LIKE ?', '%' . $searchTerm . '%')
											   ->order('title ASC');
		
		$resultSet = $this->getDbTable()->fetchAll($select);

		$entries = array();

		foreach ($resultSet as $row) {

			$category = $row->findParentRow('Admin_Model_DbTable_Categories');

			// Create an array of Courses Models for each row in the set
			$entry = new Admin_Model_Courses();
			$entry->setId($row->id)
				  ->setTitle($row->title)
				  ->setCategoryID($row->category_id)
				  ->setCategoryName($category->name)
				  ->setURLKey($row->url_key)
				  ->setSubtitle($row->subtitle)
				  ->setAims($row->aims)
				  ->setTargetAudience($row->target_audience)
				  ->setBrief($row->brief)
				  ->setBookingURL($row->booking_url)
				  ->setImage($row->image)
				  ->setMetaKeywords($row->meta_keywords)
				  ->setMetaDescription($row->meta_description);
			$entries[] = $entry;
		}
		return $entries;
	}
}

