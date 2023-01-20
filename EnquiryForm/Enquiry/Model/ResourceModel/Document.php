<?php

namespace EnquiryForm\Enquiry\Model\ResourceModel;


class Document extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
   
    protected $connection;

   
    public function __construct(
        \Magento\Framework\Model\ResourceModel\Db\Context $context,
        $connectionName = null
    ) {
        parent::__construct($context, $connectionName);
    }

   
    protected function _construct()
    {
        $this->_init('EnquiryForm_Enquiry_records', 'id');
        $this->connection = $this->getConnection();
    }
}