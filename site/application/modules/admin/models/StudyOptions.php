<?php

class Admin_Model_StudyOptions
{
	protected $_course_id;
	protected $_semester;
	protected $_days;
	protected $_dates;
	protected $_times;
	protected $_duration;
	protected $_fee;
	protected $_code;
	protected $_location;
	protected $_id;

        public function __construct(array $options = null)
        {
                if(is_array($options)) {
                        $this->setOptions($options);
                }
        }

        // Magic methods!
        // Automatically called when a protected or non-existed property is called
        public function __set($name, $value)
        {
                $method = 'set' . $name;
                if (('mapper' == $name) || !method_exists($this, $method)) {
                        throw new Exception('Invalid categories property');
                }
                $this->$method($value);
        }

        public function __get($name)
        {
                $method = 'get' . $name;
                if (('mapper' == $name) || !method_exists($this, $method)) {
                        throw new Exception('Invalid categories property');
                }
                return $this->$method();
        }

        public function setOptions(array $options)
        {
                $methods = get_class_methods($this);
                foreach ($options as $key => $value) {
                        $method = 'set' . ucfirst($key);
                        if (in_array($method, $methods)) {
                                $this->$method($value);
                        }
                }
                return $this;
        }

        public function setCourseId($id)
        {
                $this->_course_id = (int) $id;
                return $this;
        }

        public function getCourseId()
        {
                return $this->_course_id;
        }

	public function setSemester($text)
	{
		$this->_semester = (string) $text;
		return $this;
	}

	public function getSemester()
	{
		return $this->_semester;
	}

	public function setDays($text)
	{
		$this->_days = (string) $text;
		return $this;
	}

	public function getDays()
	{
		return $this->_days;
	}

	public function setDates($text)
	{
		$this->_dates = (string) $text;
		return $this;
	}

	public function getDates()
	{
		return $this->_dates;
	}

	public function setTimes($text)
	{
		$this->_times = (string) $text;
		return $this;
	}

	public function getTimes()
	{
		return $this->_times;
	}

	public function setDuration($text)
	{
		$this->_duration = (string) $text;
		return $this;
	}

	public function getDuration()
	{
		return $this->_duration;
	}

	public function setFee($fee)
	{
		$this->_fee = (string) $fee;
		return $this;
	}

	public function getFee()
	{
		return $this->_fee;
	}

	public function setCode($text)
	{
		$this->_code = (string) $text;
		return $this;
	}

	public function getCode()
	{
		return $this->_code;
	}

	public function setLocation($text)
	{
		$this->_location = (string) $text;
		return $this;
	}

	public function getLocation()
	{
		return $this->_location;
	}

	public function setId($id)
	{
		$this->_id = (int) $id;
		return $this;
	}

	public function getId()
	{
		return $this->_id;
	}

}

