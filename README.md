Magento-FeedReader
==================

An awsum feed reader for magento based on Zend_Feed supporting atom and rss
feeds.

    <default>
        <reference name="left">
            <block type="feedreader/sidebar" name="left.feedreader">
                <action method="setUri"><uri>http://rss.cnn.com/rss/edition.rss</uri></action>
            </block>
        </reference>
    </default>

FAQ
---

###  I'm having problems with the feed displaying HTML code

HTML code is escaped by default. Including 3rd-party HTML code in your site can
lead to major cross-site-scripting issues. You can adjust the behaviour in the
template. The safe way of handling HTML is to simply string the tags before
escaping. If you *really* want to print out foreign HTML code, you can do that
too, but you also have to adjust the truncate function
(see http://stackoverflow.com/questions/1193500/php-truncate-html-ignoring-tags).
