<?php

class Admin_Model_DbTable_StudyOptions extends Zend_Db_Table_Abstract
{

    protected $_name = 'study_options';

    protected $_referenceMap = array(
        'Course' => array(
                'columns' => array('course_id'),
                'refTableClass' => 'Admin_Model_DbTable_Courses',
                'refColumns' => array('id')
        )
    );

}

