<?php

class Admin_Model_NewsMapper extends Application_Model_NewsMapper
{	
	public function find($id)
	{
		$select  = $this->getDbTable()->select()->where('id = ?', $id);
		
		$select->from($this->getDbTable(),array(
			'id',
			'title',
			'url_key',
			'subtitle',
			'image',
			'content',
			'timestamp' => new Zend_Db_Expr('UNIX_TIMESTAMP(timestamp)')
		));
						   
		$row = $this->getDbTable()->fetchRow($select);

		if (count($row) == 0) {
			return; // no news
		}
		
		$news = new Application_Model_News();
		$news->setId($row->id)
			 ->setTitle($row->title)
			 ->setURLKey($row->url_key)
			 ->setSubtitle($row->subtitle)
			 ->setImage($row->image)
			 ->setContent($row->content)
		 	 ->setTimestamp($row->timestamp);

		return $news;
		
	}
	
	public function save(Application_Model_News $article)
	{

		$urlfilter = new Core_Filter_UrlKey();

		$data = array(
				'id' => $article->getId(),
				'title' => $article->getTitle(),
				'subtitle' => $article->getSubtitle(),
				'image' => $article->getImage(),
				'content' => $article->getContent(),
				'url_key' => $urlfilter->filter($article->getTitle()),
		);

		if (($id = $article->getId()) === null) {
			// INSERT
			unset($data['id']);
			return $this->getDbTable()->insert($data);
		} else {
			// UPDATE
			
			// So an update can be performed without changing the image file
			$image = $article->getImage();
			if (empty($image)) {
				unset($data['image']);
			} else {
				// We have a new image so we should unlink the old one
				unlink(APPLICATION_PATH . '/../public/uploads/' . $this->find($id)->Image);
			}
			
			$this->getDbTable()->update($data, array('id = ?' => $id));
		}
		
	}
	
	public function delete($id)
	{
		unlink(APPLICATION_PATH . '/../public/uploads/' . $this->find($id)->Image);
		
		$where = $this->getDbTable()->getAdapter()->quoteInto('id = ?', $id);
		$this->getDbTable()->delete($where);
	}

}

