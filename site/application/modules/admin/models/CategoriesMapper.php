<?php

class Admin_Model_CategoriesMapper
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
				$this->setDbTable('Admin_Model_DbTable_Categories');
		}
		return $this->_dbTable;
	}

	public function save(Admin_Model_Categories $categories)
	{

		$urlfilter = new Core_Filter_UrlKey();

		$data = array(
				'id' => $categories->getId(),
				'name' => $categories->getName(),
				'image' => $categories->getImage(),
				'description' => $categories->getDescription(),
				'adult_category' => $categories->getAdultCategory(),
				'url_key' => $urlfilter->filter($categories->getName()),
				'meta_keywords' => $categories->getMetaKeywords(),
				'meta_description' => $categories->getMetaDescription()
		);

		if (($id = $categories->getId()) === null) {
				unset($data['id']);
				return $this->getDbTable()->insert($data);
		} else {
			
			// So an update can be performed without changing the image file
			$image = $categories->getImage();
			if (empty($image)) {
				unset($data['image']);
			} else {
				// We have a new image so we should unlink the old one
				unlink(APPLICATION_PATH . '/../public/uploads/' . $this->find($id)->Image);
			}
			
			$this->getDbTable()->update($data, array('id = ?' => $id));
		}
		
	}

	public function delete($id)
	{
		unlink(APPLICATION_PATH . '/../public/uploads/' . $this->find($id)->Image);
		
		$where = $this->getDbTable()->getAdapter()->quoteInto('id = ?', $id);
		$this->getDbTable()->delete($where);
	}

	public function findByURLKey($key)
	{
		$select = $this->getDbTable()->select()->where('url_key = ?', $key);
		$row = $this->getDbTable()->fetchRow($select);

		// This just applies the row to our Model.
		// Maybe there should be an ApplyRowToModel method or something
		return $this->find(NULL, $row);
	}

	// Actually remove findByURLKey function and just add it as a parameter here
	public function find($id, $row = NULL)
	{
		if ($row === NULL) {
			$result = $this->getDbTable()->find($id);

                	if (count($result) == 0) {
                        	return;
                	}

                	$row = $result->current();
		}

		$category = new Admin_Model_Categories();
		$category->setId($row->id)
			 ->setName($row->name)
			 ->setImage($row->image)
			 ->setDescription($row->description)
			 ->setAdultCategory($row->adult_category)
			 ->setURLKey($row->url_key)
			 ->setMetaKeywords($row->meta_keywords)
			 ->setMetaDescription($row->meta_description);

		return $category;
	}

	public function fetchAll($adultCategory = NULL)
	{
		$select = $this->getDbTable()->select();
		
		if ($adultCategory !== NULL) {
			$select->where('adult_category = ?', $adultCategory);
		}
		
		$select->order('name ASC');
		
		$resultSet = $this->getDbTable()->fetchAll($select);

		$entries = array();

		foreach ($resultSet as $row) {
			$totalCourses = $row->findDependentRowset('Admin_Model_DbTable_Courses', 'Category');

			$entry = new Admin_Model_Categories();
			$entry->setId($row->id)
			      ->setName($row->name)
				  ->setImage($row->image)
				  ->setDescription($row->description)
			      ->setAdultCategory($row->adult_category)
			      ->setURLKey($row->url_key)
			      ->setTotalCourses(count($totalCourses))
			      ->setMetaKeywords($row->meta_keywords)
			      ->setMetaDescription($row->meta_description);
			$entries[] = $entry;
		}
		
		return $entries;
	}
}

