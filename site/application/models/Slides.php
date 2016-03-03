<?php

class Application_Model_Slides extends Application_Model_DbTableModel
{
	protected $_slideshow_id;
	protected $_file_name = '';
	protected $_color_code = '';
	protected $_href = '';
	protected $_original_file_name = '';
	protected $_slide_order;

	public function setSlideShowId($int)
	{
		$this->_slideshow_id = (int) $int;
		return $this;
	}
	
	public function getSlideShowId()
	{
		return $this->_slideshow_id;
	}

	public function setFileName($text)
	{
		$this->_file_name = $text;
		return $this;
	}
	
	public function getFileName()
	{
		return $this->_file_name;
	}
	
	public function setColorCode($text)
	{
		$this->_color_code = $text;
		return $this;
	}
	
	public function getColorCode()
	{
		return $this->_color_code;
	}
	
	public function setHref($text)
	{
		$this->_href = $text;
		return $this;
	}
	
	public function getHref()
	{
		return $this->_href;
	}
	
	public function setOriginalFileName($text)
	{
		$this->_original_file_name = $text;
		return $this;
	}
	
	public function getOriginalFileName()
	{
		return $this->_original_file_name;
	}
	
	public function setSlideOrder($int)
	{
		$this->_slide_order = (int) $int;
		return $this;
	}
	
	public function getSlideOrder()
	{
		return $this->_slide_order;
	}

}

