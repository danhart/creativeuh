<?php

class Admin_Model_Courses
{
	protected $_title;
	protected $_category_id;
	protected $_category_name;
	protected $_category_url_key;
	protected $_url_key;
	protected $_subtitle;
	protected $_aims;
	protected $_target_audience;
	protected $_brief;
	protected $_booking_url;
	protected $_image;
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
			throw new Exception('Invalid courses property');
		}
		$this->$method($value);
	}

	public function __get($name)
	{
		$method = 'get' . $name;
		if (('mapper' == $name) || !method_exists($this, $method)) {
                        throw new Exception('Invalid courses property');
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

	public function setTitle($text)
	{
		$this->_title = (string) $text;
		return $this;
	}

	public function getTitle()
	{
		return $this->_title;
	}

	public function setCategoryID($id)
	{
		$this->_category_id = (string) $id;
		return $this;
	}

	public function getCategoryID()
	{
		return $this->_category_id;
	}

	public function setCategoryName($text)
	{
		$this->_category_name = (string) $text;
		return $this;
	}

	public function getCategoryName()
	{
		return $this->_category_name;
	}
	
	public function setCategoryURLKey($text)
	{
		$this->_category_url_key = (string) $text;
		return $this;
	}

	public function getCategoryURLKey()
	{
		return $this->_category_url_key;
	}

	public function setURLKey($url_key)
	{
		// Apply url key filter here?
		$this->_url_key = (string) $url_key;
		return $this;
	}

	public function getURLKey()
	{
		return $this->_url_key;
	}

	public function setSubtitle($text)
	{
		$this->_subtitle = (string) $text;
		return $this;
	}

	public function getSubtitle()
	{
		return $this->_subtitle;
	}

	public function setAims($text)
	{
		$this->_aims = (string) $text;
		return $this;
	}

	public function getAims()
	{
		return $this->_aims;
	}

	public function setTargetAudience($text)
	{
		$this->_target_audience = (string) $text;
		return $this;
	}

	public function getTargetAudience()
	{
		return $this->_target_audience;
	}

	public function setBrief($text)
	{
		$this->_brief = (string) $text;
		return $this;
	}

	public function getBrief()
	{
		return $this->_brief;
	}

	public function setBookingURL($url)
	{
		$this->_booking_url = (string) $url;
		return $this;
	}

	public function getBookingURL()
	{
		return $this->_booking_url;
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

