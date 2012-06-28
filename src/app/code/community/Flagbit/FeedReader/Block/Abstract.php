<?php
/**
 * Magento
 *
 * @category   Flagbit
 * @package    Flagbit_FeedReader
 * @copyright  Copyright (c) 2010 Flagbit GmbH & Co. KG (http://www.flagbit.de)
 */

/**
 * Abstract feed reader block
 *
 * @category   Flagbit
 * @package    Flagbit_FeedReader
 * @author     David Fuhr <fuhr@flagbit.de>
 */
abstract class Flagbit_FeedReader_Block_Abstract extends Mage_Core_Block_Template
{
	/**
	 * The constructor
	 * 
	 * @return Flagbit_FeedReader_Block_Abstract
	 */
	public function __construct()
	{
		parent::__construct();
		
		// set up the cache
		$this->setCacheLifetime(60 * 30); // 30 minutes
	}
	
	/**
	 * Sets the feed uri
	 * 
	 * @param string $uri The feed uri
	 * @return Flagbit_FeedReader_Block_Abstract
	 */
	public function setUri($uri)
	{
		$this->setData('uri', (string) $uri);
		return $this;
	}
	
	/**
	 * Returns the feed
	 * 
	 * Tries to create the feed from the URI.
	 * 
	 * @return Zend_Feed
	 */
	protected function getFeed()
	{
		$feed = $this->getData('feed');
		if (is_null($feed)) {
			$uri = $this->getData('uri');
			if (!is_null($uri)) {
				try {
					$feed = Zend_Feed::import($uri);
					$this->setData('feed', $feed);
				}
				catch (Zend_Http_Client_Exception $e) {
					Mage::logException($e);
				}
				catch (Zend_Feed_Exception $e) {
					Mage::logException($e);
				}
			}
		}
		return $feed;
	}
	
	/**
	 * Extends cache key with feed url, layout, template and locale
	 * 
	 * @return array
	 */
	public function getCacheKeyInfo()
	{
		return array_merge(
			parent::getCacheKeyInfo(),
			array(
				$this->getData('uri'),
				Mage::getDesign()->getTheme('layout'),
				Mage::getDesign()->getTheme('template'),
				Mage::getDesign()->getTheme('locale')
			)
		);
	}
	
	/**
	 * Sets the item count
	 * 
	 * The item count defines how many feed items are displayed.
	 * 
	 * @param int $itemCount The value is cast to int
	 * @return Flagbit_FeedReader_Block_Abstract
	 */
	public function setItemCount($itemCount)
	{
		$this->setData('item_count', (int) $itemCount);
		return $this;
	}
	
	/**
	 * Returns the item count
	 * 
	 * @return int
	 */
	public function getItemCount()
	{
		$itemCount = 0;
		if (!is_null($this->getFeed())) {
			$itemCount = $this->getData('item_count');
			if ($this->getFeed()->count() < $itemCount || is_null($this->getData('item_count'))) {
				$itemCount = $this->getFeed()->count();
			}
		}
		return $itemCount;
	}
	
	/**
	 * Returns the feed title
	 * 
	 * If no feed is defined an empty string is returned.
	 * 
	 * @return string
	 */
	public function getTitle()
	{
		$title = '';
		if (!is_null($this->getData('title'))) {
			$title = $this->getData('title');
		}
		else if (!is_null($this->getFeed())) {
			$title = $this->getFeed()->title();
		}
		return $title;
	}
	
	/**
	 * Sets the block's title
	 * 
	 * This overrides the feed title.
	 * 
	 * @param string $title
	 * @return Flagbit_FeedReader_Block_Abstract
	 */
	public function setTitle($title)
	{
		$this->setData('title', (string) $title);
		return $this;
	}
	
	/**
	 * Returns the feed items
	 * 
	 * @return array
	 */
	public function getItems()
	{
		$return = array();
		if (!is_null($this->getFeed())) {
			$itemCount = 0;
			foreach ($this->getFeed() as $item) {
				$return[] = $item;
				if (++$itemCount >= $this->getItemCount()) {
					break;
				}
			}
		}
		return $return;
	}
}
