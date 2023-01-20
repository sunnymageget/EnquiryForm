<?php
namespace EnquiryForm\Enquiry\Model\ResourceModel\Document; 

use Magento\Framework\Data\Collection\EntityFactory;
use Psr\Log\LoggerInterface;
use Magento\Framework\Data\Collection\Db\FetchStrategyInterface;
use Magento\Framework\Event\ManagerInterface; 
use Magento\Framework\DB\Adapter\AdapterInterface;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{

    public function __construct(
       EntityFactory $entityFactory,
       LoggerInterface $logger,
       FetchStrategyInterface $fetchStrategy,
       ManagerInterface $eventManager,
       AdapterInterface $connection = null,
       AbstractDb $resource = null
    ) {
        parent::__construct($entityFactory, $logger, $fetchStrategy, $eventManager, $connection, $resource);
    }

    protected function _construct()
    {
        parent::_construct();
        $this->_init(
            \EnquiryForm\Enquiry\Model\Document::class,
            \EnquiryForm\Enquiry\Model\ResourceModel\Document::class
        );
    }

}