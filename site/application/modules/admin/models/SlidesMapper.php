<?php

class Admin_Model_SlidesMapper extends Application_Model_SlidesMapper
{
	public function delete($slideid)
	{
		$where = $this->getDbTable()->getAdapter()->quoteInto('id = ?', $slideid);
		
		if (!empty($this->getDbTable()->find($slideid)->current()->file_name)) {
			unlink(APPLICATION_PATH . '/../public/uploads/' . $this->getDbTable()->find($slideid)->current()->file_name);
		}
		
		$this->getDbTable()->delete($where);
	}
	
	public function reorder($slidesArr)
	{	
		foreach ($slidesArr as $order=>$slide_id) {
			$data = array(
				'slide_order' => $order
			);
			
			$this->getDbTable()->update($data, array('id = ?' => ltrim($slide_id, 'slide_')));
		}
	}
	
	public function save(Application_Model_Slides $slide)
	{
		// Map each database entity to the passed instance of the Courses Model
		$data = array(
			'id' => $slide->getId(),
			'slideshow_id' => $slide->getSlideShowId(),
			'file_name' => $slide->getFileName(),
			'color_code' => $slide->getColorCode(),
			'href' => $slide->getHref(),
			// 'original_file_name' => $slide->getOriginalFileName(),
			'slide_order' => '0'
		);
		
		$imageFile = $slide->getFileName();
		if (empty($imageFile)) {
			unset($data['file_name']);
		}
		
		unset($data['id']);

		// Insert and return the inserted row's id
		return $this->getDbTable()->insert($data);
	}
}