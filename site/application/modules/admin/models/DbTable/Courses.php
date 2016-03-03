<?php

class Admin_Model_DbTable_Courses extends Zend_Db_Table_Abstract
{

    protected $_name = 'courses';

    protected $_dependentTables = array('Admin_Model_DbTable_StudyOptions', 'Admin_Model_DbTable_RelatedCourses');

    protected $_referenceMap = array(
	'Category' => array(
		'columns' => array('category_id'),
		'refTableClass' => 'Admin_Model_DbTable_Categories',
		'refColumns' => array('id')
	)
    );

}

