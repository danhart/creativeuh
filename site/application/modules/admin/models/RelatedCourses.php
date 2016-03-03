<?php

class Admin_Model_RelatedCourses extends Application_Model_DbTableModel
{
	protected $_course_id;
	protected $_related_course_id;
	protected $_related_course_title;
	protected $_related_course_url_key;

	public function setCourseId($id)
	{
			$this->_course_id = (int) $id;
			return $this;
	}

	public function getCourseId()
	{
			return $this->_course_id;
	}

	public function setRelatedCourseId($id)
	{
			$this->_related_course_id = (int) $id;
			return $this;
	}

	public function getRelatedCourseId()
	{
			return $this->_related_course_id;
	}

	public function setRelatedCourseTitle($text)
	{
		$this->_related_course_title = (string) $text;
		return $this;
	}

	public function getRelatedCourseTitle()
	{
		return $this->_related_course_title;
	}
	
	public function setRelatedCourseURLKey($text)
	{
		$this->_related_course_url_key = (string) $text;
		return $this;
	}

	public function getRelatedCourseURLKey()
	{
		return $this->_related_course_url_key;
	}
}

