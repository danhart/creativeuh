<?php

class Core_Filter_UrlKey implements Zend_Filter_Interface
{
	public function filter($value)
	{

		$value = trim($value);
		$value = strtolower($value);
		$value = str_replace('&','and',$value);

		// Apply alnum to filter out all all other characters but retain whitespace
		$alnum = new Zend_Filter_Alnum(array('allowwhitespace' => true));
		$value = $alnum->filter($value);

		// Replace 1 or more spaces with dashes
		$value = preg_replace('/\s+/', '-', $value);

		return $value;
	}
}
