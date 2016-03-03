<?php

class Admin_Model_DbTable_RelatedCourses extends Zend_Db_Table_Abstract
{

    protected $_name = 'related_courses';

    protected $_referenceMap = array(
        'Course_Id' => array(
                'columns' => array('course_id'),
                'refTableClass' => 'Admin_Model_DbTable_Courses',
                'refColumns' => array('id')
        ),
	'Related_Course_Id' => array(
                'columns' => array('related_course_id'),
                'refTableClass' => 'Admin_Model_DbTable_Courses',
                'refColumns' => array('id')
        )
    );

}

