<?php

class Admin_Model_StudyOptionsMapper
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
                        $this->setDbTable('Admin_Model_DbTable_StudyOptions');
                }
                return $this->_dbTable;
        }

        public function delete($id)
        {
                $where = $this->getDbTable()->getAdapter()->quoteInto('id = ?', $id);
                $this->getDbTable()->delete($where);
        }

	public function save(Admin_Model_StudyOptions $studyoptions)
	{
		$data = array(
			'id' => $studyoptions->getId(),
			'course_id' => $studyoptions->getCourseId(),
			'semester' => $studyoptions->getSemester(),
			'days' => $studyoptions->getDays(),
			'dates' => $studyoptions->getDates(),
			'times' => $studyoptions->getTimes(),
			'duration' => $studyoptions->getDuration(),
			'fee' => $studyoptions->getFee(),
			'code' => $studyoptions->getCode(),
			'location' => $studyoptions->getLocation()
		);

		if (($id = $studyoptions->getId()) === null) {
			unset($data['id']);

			// Insert and return the inserted row's id
			return $this->getDbTable()->insert($data);

		} else {
			$this->getDbTable()->update($data, array('id = ?' => $id));
		}
	}

	public function find($studyOptionId)
	{
		$result = $this->getDbTable()->find($studyOptionId);

                if (count($result) == 0) {
                        return; // no course found
                }

                // I assume this narrows down the resultSet to just one row.
                $row = $result->current(); // Get the selected row

		$studyoption = new Admin_Model_StudyOptions();
		$studyoption->setId($row->id)
                	 ->setCourseId($row->course_id)
                         ->setSemester($row->semester)
                         ->setDays($row->days)
                         ->setDates($row->dates)
                         ->setTimes($row->times)
                         ->setDuration($row->duration)
                         ->setFee($row->fee)
                         ->setCode($row->code)
                         ->setLocation($row->location);

                return $studyoption;
	}

        public function fetchAll($courseId)
        {
		$select = $this->getDbTable()->select()->where('course_id = ?', $courseId);

                $resultSet = $this->getDbTable()->fetchAll($select);

                $entries = array();

                foreach ($resultSet as $row) {
                        $entry = new Admin_Model_StudyOptions();
                        $entry->setId($row->id)
                              ->setCourseId($row->course_id)
			      ->setSemester($row->semester)
			      ->setDays($row->days)
			      ->setDates($row->dates)
			      ->setTimes($row->times)
			      ->setDuration($row->duration)
			      ->setFee($row->fee)
			      ->setCode($row->code)
			      ->setLocation($row->location);
                        $entries[] = $entry;
                }
                return $entries;
        }

}

