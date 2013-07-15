<?php
/**
 * Magento
 *
 * @category   Flagbit
 * @package    Flagbit_FeedReader
 * @copyright  Copyright (c) 2012 Flagbit GmbH & Co. KG (http://www.flagbit.de)
 */

/**
 * Feed reader category feed
 *
 * @category   Flagbit
 * @package    Flagbit_FeedReader
 * @author     Nicolai Essig <nicolai.essig@flagbit.de>
 */
class Flagbit_FeedReader_Block_Product
	extends Flagbit_FeedReader_Block_Abstract
{
	/**
	 * The constructor
	 * 
	 * @return Flagbit_FeedReader_Block_Category
	 */
	public function __construct()
	{
		parent::__construct();

        // set the template
        $this->setTemplate('feedreader/sidebar.phtml');

        // set the category feed url
        $this->setUri(
            Mage::registry('current_product')->getFeedreaderUrl()
        );
	}

    /**
     * Extends cache key with category id
     *
     * @return array
     */
    public function getCacheKeyInfo()
    {
        return array_merge(
            parent::getCacheKeyInfo(),
            array(
                Mage::registry('current_product')->getId()
            )
        );
    }
}
