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
	protected $feed = null;
	private $itemCount = 5;
	
	/**
	 * The constructor
	 * 
	 * @return Flagbit_FeedReader_Block_Abstract
	 */
	public function __construct()
	{
		parent::__construct();
		
		// set the template
		$this->setTemplate('feedreader/sidebar.phtml');
		
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
		try
		{
			$this->feed = new Zend_Feed_Rss($uri);
			$this->setCacheTag($uri);
		}
		catch(Zend_Feed_Exception $e)
		{
			Mage::logException($e);
		}
		return $this;
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
		$this->itemCount = (int) $itemCount;
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
		if(!is_null($this->feed))
		{
			$itemCount = $this->itemCount;
			if($this->feed->count() < $itemCount)
			{
				$itemCount = $this->feed->count();
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
		if(!is_null($this->feed))
		{
			$title = $this->feed->title();
		}
		return $title;
	}
	
	public function getItems()
	{
		$return = array();
		if(!is_null($this->feed))
		{
			$itemCount = 0;
			foreach($this->feed as $item)
			{
				$return[] = $item;
				if(++$itemCount >= $this->getItemCount())
				{
					break;
				}
			}
		}
		return $return;
	}
}
