<?php

namespace EnquiryForm\Enquiry\Controller\Form;
use EnquiryForm\Enquiry\Helper\Data;

class Index extends \Magento\Framework\App\Action\Action
{
	protected $_pageFactory;
	protected $_forwardFactory;
	protected $_moduleManager;
	protected $_helperData;

	public function __construct(
		\Magento\Framework\App\Action\Context $context,
		\Magento\Framework\View\Result\PageFactory $pageFactory,
		\Magento\Framework\Controller\Result\ForwardFactory $forwardFactory,
		\Magento\Framework\Module\Manager $moduleManager,
		Data $helperData
		
		)
	{
		$this->_pageFactory = $pageFactory;
		$this->_forwardFactory = $forwardFactory;
		$this->_moduleManager = $moduleManager;
		$this->_helperData = $helperData;
		return parent::__construct($context);
	}

	public function execute()
	{

			$module_status = $this->_helperData->isEnable();

		if ($module_status){
			return $this->_pageFactory->create();
        } else {
            $resultForward = $this->_forwardFactory->create();
            $resultForward->setController('index');
            $resultForward->forward('defaultNoRoute');
            return $resultForward;
        }
		
	}

} 


