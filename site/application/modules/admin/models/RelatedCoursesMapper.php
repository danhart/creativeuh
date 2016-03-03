<?php

class Admin_Model_RelatedCoursesMapper
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
                        $this->setDbTable('Admin_Model_DbTable_RelatedCourses');
                }
                return $this->_dbTable;
        }

	public function saveAll($courseid, $relatedcourses)
	{
		// First clear out all
		$this->deleteAll($courseid);

		$entries = array();
		// Could probably combine these two foreach loops into one. But this way is nice and clear.

		if(is_array($relatedcourses)) {
		// Create array of models from the form data
		foreach($relatedcourses as $relatedcourse) {
			$entry = new Admin_Model_RelatedCourses();
			$entry->setCourseId($courseid)
			      ->setRelatedCourseId($relatedcourse);
			$entries[] = $entry;
		}

		// Insert the models into the database
		foreach($entries as $relatedcoursemodel) {
			$data = array(
				'course_id' => $relatedcoursemodel->getCourseId(),
				'related_course_id' => $relatedcoursemodel->getRelatedCourseId()
			);
			$this->getDbTable()->insert($data);
		}
		}
	}

	public function deleteAll($courseid)
	{
		$where = $this->getDbTable()->getAdapter()->quoteInto('course_id = ?', $courseid);
                $this->getDbTable()->delete($where);
	}

	public function fetchAll($courseId)
        {
                $select = $this->getDbTable()->select()->where('course_id = ?', $courseId);

                $resultSet = $this->getDbTable()->fetchAll($select);

                $entries = array();

                foreach ($resultSet as $row) {

			$course = $row->findParentRow('Admin_Model_DbTable_Courses', 'Related_Course_Id');

                        $entry = new Admin_Model_RelatedCourses();
                        $entry->setId($row->id)
                              ->setCourseId($row->course_id)
			      			  ->setRelatedCourseId($row->related_course_id)
			      			  ->setRelatedCourseTitle($course->title)
							  ->setRelatedCourseURLKey($course->url_key);
                        $entries[] = $entry;
                }
                return $entries;
        }

	public function populateForm($courseId)
        {
                $select = $this->getDbTable()->select()->from(array('r' => 'related_courses'), array('related_course_id'))
						       ->where('course_id = ?', $courseId);

                $resultSet = $this->getDbTable()->fetchAll($select);

		$results = array();

		foreach ($resultSet->toArray() as $result) {
			$results[] = $result['related_course_id'];
		}

		return $results;
        }
}

