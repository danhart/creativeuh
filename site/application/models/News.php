<?php

class Application_Model_News extends Application_Model_DbTableModel
{
	protected $_title;
	protected $_url_key;
	protected $_subtitle;
	protected $_image;
	protected $_content;
	protected $_timestamp;
	
	public function setTitle($text)
	{
		$this->_title = (string) $text;
		return $this;
	}
	
	public function getTitle()
	{
		return $this->_title;
	}
	
	public function setURLKey($text)
	{
		$this->_url_key = (string) $text;
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
	
	public function setImage($text)
	{
		$this->_image = (string) $text;
		return $this;
	}
	
	public function getImage()
	{
		return $this->_image;
	}
	
	public function setContent($text)
	{
		$this->_content = (string) $text;
		return $this;
	}
	
	public function getContent()
	{
		return $this->_content;
	}
	
	public function setTimestamp($unix_timestamp)
	{
		$this->_timestamp = (int) $unix_timestamp;
		return $this;
	}
	
	public function getTimestamp()
	{
		return $this->_timestamp;
	}

}

