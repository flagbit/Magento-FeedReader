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
	 * @var Zend_Feed_Abstract
	 */
	protected $_feed = null;
	
	/**
	 * @var string
	 */
	protected $_title = null;
	
	/**
	 * @var int
	 */
	private $_itemCount = 5;
	
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
		try {
			$this->_feed = Zend_Feed::import($uri);
			// update the cache tag
			$this->setCacheKey($uri);
		}
		catch (Zend_Http_Client_Adapter_Exception $e) {
			Mage::logException($e);
		}
		catch (Zend_Feed_Exception $e) {
			Mage::logException($e);
		}
		return $this;
	}
	
	/**
	 * Sets the cache key
	 * 
	 * The cache key is extended by the layout, template and locale.
	 * 
	 * @param string $cacheKey
	 * @return Flagbit_FeedReader_Block_Abstract
	 */
	protected function setCacheKey($cacheKey)
	{
		$cacheKey = (string) $cacheKey;
		
		$cacheKey .= ':' . Mage::getDesign()->getTheme('layout');
		$cacheKey .= ':' . Mage::getDesign()->getTheme('template');
		$cacheKey .= ':' . Mage::getDesign()->getTheme('locale');
		
		return $this->setData('cache_key', $cacheKey);
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
		$this->_itemCount = (int) $itemCount;
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
		if (!is_null($this->_feed)) {
			$itemCount = $this->_itemCount;
			if ($this->_feed->count() < $itemCount) {
				$itemCount = $this->_feed->count();
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
		if (!is_null($this->_title)) {
			$title = $this->_title;
		}
		else if (!is_null($this->_feed)) {
			$title = $this->_feed->title();
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
		$this->_title = (string) $title;
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
		if (!is_null($this->_feed)) {
			$itemCount = 0;
			foreach ($this->_feed as $item) {
				$return[] = $item;
				if (++$itemCount >= $this->getItemCount()) {
					break;
				}
			}
		}
		return $return;
	}
}
