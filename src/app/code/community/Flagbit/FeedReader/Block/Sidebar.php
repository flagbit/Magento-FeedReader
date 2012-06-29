<?php
/**
 * Magento
 *
 * @category   Flagbit
 * @package    Flagbit_FeedReader
 * @copyright  Copyright (c) 2012 Flagbit GmbH & Co. KG (http://www.flagbit.de)
 */

/**
 * Feed reader sidebar
 *
 * @category   Flagbit
 * @package    Flagbit_FeedReader
 * @author     David Fuhr <fuhr@flagbit.de>
 */
class Flagbit_FeedReader_Block_Sidebar
	extends Flagbit_FeedReader_Block_Abstract
	implements Mage_Widget_Block_Interface
{
	/**
	 * The constructor
	 * 
	 * @return Flagbit_FeedReader_Block_Sidebar
	 */
	public function __construct()
	{
		parent::__construct();
		
		// set the template
		$this->setTemplate('feedreader/sidebar.phtml');
	}
}
