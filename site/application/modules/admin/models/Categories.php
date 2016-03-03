<?php

// I should make a class for this e.g. My Model and then extend it rather than defining so many of the methods each time
class Admin_Model_Categories
{
	protected $_name;
	protected $_image;
	protected $_description;
	protected $_adult_category;
	protected $_url_key;
	protected $_total_courses;
	protected $_meta_keywords;
	protected $_meta_description;
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

	public function setName($text)
	{
			$this->_name = (string) $text;
			return $this;
	}

	public function getName()
	{
			return $this->_name;
	}
	
	public function setImage($text)
	{
			$this->_image = (string) $text;
			return $this;
	}

	public function getImage()
	{
			return $this->_image;
	}
	
	public function setDescription($text)
	{
			$this->_description = (string) $text;
			return $this;
	}

	public function getDescription()
	{
			return $this->_description;
	}

	public function setAdultCategory($boolean)
	{
		$this->_adult_category = (int) $boolean;
		return $this;
	}

	public function getAdultCategory()
	{
		return $this->_adult_category;
	}

	public function setURLKey($url_key)
	{
			$this->_url_key = (string) $url_key;
			return $this;
	}

	public function getURLKey()
	{
			return $this->_url_key;
	}

	public function setTotalCourses($total)
	{
		$this->_total_courses = (int) $total;
		return $this;
	}

	public function getTotalCourses()
	{
		return $this->_total_courses;
	}

	public function setMetaKeywords($text)
	{
			$this->_meta_keywords = (string) $text;
			return $this;
	}

	public function getMetaKeywords()
	{
			return $this->_meta_keywords;
	}

	public function setMetaDescription($text)
	{
			$this->_meta_description = (string) $text;
			return $this;
	}

	public function getMetaDescription()
	{
			return $this->_meta_description;
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

