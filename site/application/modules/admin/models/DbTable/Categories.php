<?php

class Admin_Model_DbTable_Categories extends Zend_Db_Table_Abstract
{

    protected $_name = 'course_categories';

    protected $_dependentTables = array('Admin_Model_DbTable_Courses');

}

