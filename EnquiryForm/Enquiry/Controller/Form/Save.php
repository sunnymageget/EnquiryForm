<?php
namespace EnquiryForm\Enquiry\Controller\Form;

use Zend\Log\Filter\Timestamp;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\MediaStorage\Model\File\UploaderFactory;
use Magento\Framework\Image\AdapterFactory;
use Magento\Framework\Filesystem; 
use Magento\Framework\View\Result\PageFactory;

class Save extends \Magento\Framework\App\Action\Action
{
    const XML_PATH_EMAIL_RECIPIENT_NAME = 'trans_email/ident_support/name';
    const XML_PATH_EMAIL_RECIPIENT_EMAIL = 'trans_email/ident_support/email';

    protected $resultPageFactory;
    protected $_inlineTranslation;
    protected $_transportBuilder;
    protected $_scopeConfig;
    protected $_logLoggerInterface;
    protected $storeManager;

    protected $modelFactory;
	protected $uploaderFactory;
    protected $_mediaDirectory;
    protected $adapterFactory;
    protected $filesystem;

    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\Translate\Inline\StateInterface $inlineTranslation,
        \Magento\Framework\Mail\Template\TransportBuilder $transportBuilder,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Psr\Log\LoggerInterface $loggerInterface,
        StoreManagerInterface $storeManager,
        \EnquiryForm\Enquiry\Model\DocumentFactory $modelFactory,
        UploaderFactory $uploaderFactory,
        AdapterFactory $adapterFactory,
        Filesystem $filesystem,
        PageFactory $resultPageFactory,
        array $data = []

    )
    {
        $this->_inlineTranslation = $inlineTranslation;
        $this->_transportBuilder = $transportBuilder;
        $this->_scopeConfig = $scopeConfig;
        $this->resultPageFactory = $resultPageFactory;
        $this->_logLoggerInterface = $loggerInterface;
        $this->messageManager = $context->getMessageManager();
        $this->modelFactory = $modelFactory;
        $this->uploaderFactory = $uploaderFactory;
        $this->adapterFactory = $adapterFactory;
        $this->filesystem = $filesystem; 
        $this->storeManager = $storeManager;
        $this->_mediaDirectory = $filesystem->getDirectoryWrite(\Magento\Framework\App\Filesystem\DirectoryList::MEDIA);
        parent::__construct($context);


    }

    public function execute()
    {
        $post = $this->getRequest()->getPost();
        $resultRedirect = $this->resultRedirectFactory->create();
        try
        {
            // Send Mail
            $this->_inlineTranslation->suspend();

            $sender = [
                'name' => $post['name'],
                'email' => $post['email']
            ];

            $sentToEmail = $this->_scopeConfig ->getValue('trans_email/ident_general/email',\Magento\Store\Model\ScopeInterface::SCOPE_STORE);

            $sentToName = $this->_scopeConfig ->getValue('trans_email/ident_general/name',\Magento\Store\Model\ScopeInterface::SCOPE_STORE);

            $transport = $this->_transportBuilder
                ->setTemplateIdentifier('email_section_sendmail_email_template')
                ->setTemplateOptions(
                    [
                        'area' => 'frontend',
                        'store' => $this->storeManager->getStore()->getId()
                    ]
                )
                ->setTemplateVars([
                    'name'  => $post['name'],
                    'email'  => $post['email'],
                    'phonenumber' => $post['phonenumber'],
                    'dob' => $post['dob'] ,
                    'message' => $post['message']
                ])
                ->setFrom($sender)
                ->addTo($sentToEmail,$sentToName)
                ->addTo('sunny@mageget.com','owner')
                ->addBcc(
                    [$post['email']]
                 )
                ->getTransport();

            $transport->sendMessage();

            $this->_inlineTranslation->resume();


        $data = $this->getRequest()->getParams();
        $Cmessagedata = $this->modelFactory->create();
        if ($data){
            $files = $this->getRequest()->getFiles();
            if (isset($files['upload_file']) && !empty($files['upload_file']["name"])){
                try{
                    $files = $this->getRequest()->getFiles('file');
                    $target = $this->_mediaDirectory->getAbsolutePath('EnquiryForm_enquiry/');        
                    //attachment is the input file name posted from your form
                    $uploader = $this->uploaderFactory->create(['fileId' => 'upload_file']);
                    $_fileType = $uploader->getFileExtension();
                    $uniqid = uniqid();
                    $newFileName = $uniqid .'.'. $_fileType;
                    $uploader->setAllowedExtensions(['jpg', 'jpeg', 'png']);

                    $uploader->setAllowRenameFiles(true);

                    $result = $uploader->save($target,$newFileName); 
                    //Set file path with name for save into database
                    $post_data = $this->getRequest()->getPostValue();

                    $post_data['upload_file'] =  $newFileName;
                    
                    
                    $Cmessagedata->setData($post_data);
                    $Cmessagedata->save();

                    $this->messageManager->addSuccess(__("Save Data Successfully"));
                    $this->resultPageFactory->create();
                    return $resultRedirect->setPath('enquiry/form/index');

                   
                } catch (\Exception $e) {
                    $this->messageManager->addErrorMessage($e->getMessage()); 
                    return $resultRedirect->setPath('enquiry/form/index');
                }
            }
            else{
                $post_data = $this->getRequest()->getPostValue();
               
                $Cmessagedata->setData($post_data);
                $Cmessagedata->save();
                $this->messageManager->addSuccess(__("Save Data Successfully"));
                $this->resultPageFactory->create();
                return $resultRedirect->setPath('enquiry/form/index');
            }
        }

            

        } catch(\Exception $e){
            $this->messageManager->addError($e->getMessage());
            $this->_logLoggerInterface->debug($e->getMessage());
            $this->_redirect('enquiry/form/index');
        }



    }
}