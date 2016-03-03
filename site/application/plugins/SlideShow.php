<?php

class Application_Plugin_SlideShow extends Zend_Controller_Plugin_Abstract
{
	
	protected $_parent_pages;
	
	public function preDispatch(Zend_Controller_Request_Abstract $request)
	{	
		$view = Zend_Controller_Front::getInstance()->getParam('bootstrap')->getResource('view');

		$activePage = $view->navigation()->findOneBy('active', true);
		
		// If we don't have an active page then do nothing
		if ($activePage !== NULL) {
			
			$activePageLabel = $activePage->get('label');
			
			// Find the slideshow from the page_label
			$slideshows = new Application_Model_SlideshowsMapper;
			$slideshow = $slideshows->fetchRow($activePageLabel);
			
			$slidesMapper = new Application_Model_SlidesMapper;
			
			// We have a slideshow
			if (count($slideshow)) {
				$slides = $slidesMapper->fetchAll($slideshow->getId());
				
				// We have slides
				if (count($slides)) {
					$image_file = $slides[0]->getFileName();
					
					// If it's just one slide with no image then just change the background color of the header
					// Otherwise add the slideshow to our view
					if ( (count($slides) == 1) && (empty($image_file)) ) {
						$view->headerBgColor = $slides[0]->getColorCode();
					} else {
						$view->slideShow = $slides;
					}
				}
			} else {
				// We don't have a slideshow for this page, let's check if any of the parents do!
				
				$this->traceToRoot($activePage);
				
				if (is_array($this->_parent_pages)) {
				
					foreach($this->_parent_pages as $parentPage) {
						
						$parentPageLabel = $parentPage->get('label');
						
						$parentSlideshow = $slideshows->fetchRow($parentPageLabel);
						
						if (count($parentSlideshow)) {
						
							// We found a parent slideshow so let's get its slides
							$parentSlides = $slidesMapper->fetchAll($parentSlideshow->getId());
						
							// The parent has slides so let's use the first slides background color in our view
							if (count($parentSlides)) {
								$view->headerBgColor = $parentSlides[0]->getColorCode();
							} else {
								// No slides so let's just use a default color
								$view->headerBgColor = '70c3f7';
							}
							// We only need the first parents slideshow to be applied not grandparents etc.
							break;
						}
					}
				}
			}
		}
	}
	
	protected function traceToRoot($page)
	{
		$parentPage = $page->getParent();
		if (($parentPage instanceof Zend_Navigation_Page_Uri) || ($parentPage instanceof Zend_Navigation_Page_Mvc)) {
			
			$this->_parent_pages[] = $parentPage;
			return $this->traceToRoot($parentPage);
		}
	}
}