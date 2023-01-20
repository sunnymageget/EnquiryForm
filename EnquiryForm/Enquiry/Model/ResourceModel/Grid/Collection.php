<?php


namespace EnquiryForm\Enquiry\Model\ResourceModel\Grid;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
   
    protected $_idFieldName = 'id';
    
    protected function _construct()
    {
        $this->_init('EnquiryForm\Enquiry\Model\Grid', 'EnquiryForm\Enquiry\Model\ResourceModel\Grid');
    }
}