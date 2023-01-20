<?php
namespace EnquiryForm\Enquiry\Controller\Adminhtml\Grid;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\MediaStorage\Model\File\UploaderFactory;
use Magento\Framework\Image\AdapterFactory;
use Magento\Framework\Filesystem; 
use Magento\Framework\View\Result\PageFactory;

class Save extends \Magento\Backend\App\Action
{
    /**
     * @var \EnquiryForm\Enquiry\Model\GridFactory
     */
    var $gridFactory;
    protected $storeManager;
    protected $modelFactory;
	protected $uploaderFactory;
    protected $_mediaDirectory;
    protected $adapterFactory;
    protected $filesystem;

    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \EnquiryForm\Enquiry\Model\GridFactory $gridFactory
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \EnquiryForm\Enquiry\Model\GridFactory $gridFactory,
        StoreManagerInterface $storeManager,
        \EnquiryForm\Enquiry\Model\DocumentFactory $modelFactory,
        UploaderFactory $uploaderFactory,
        AdapterFactory $adapterFactory,
        Filesystem $filesystem,
        PageFactory $resultPageFactory,
        array $data = []
    ) {
        parent::__construct($context);
        $this->gridFactory = $gridFactory;
        $this->resultPageFactory = $resultPageFactory;
       
        $this->messageManager = $context->getMessageManager();
        $this->modelFactory = $modelFactory;
        $this->uploaderFactory = $uploaderFactory;
        $this->adapterFactory = $adapterFactory;
        $this->filesystem = $filesystem; 
        $this->storeManager = $storeManager;
        $this->_mediaDirectory = $filesystem->getDirectoryWrite(\Magento\Framework\App\Filesystem\DirectoryList::MEDIA);
    }


    public function execute()
    {
        $post = $this->getRequest()->getPost();
        $resultRedirect = $this->resultRedirectFactory->create();

            // echo"<pre>";
            // print_r("$rowData");
            // die("sunny");


        try
        {
      
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
                    return $resultRedirect->setPath('magegetenquiry/grid/');

                   
                } catch (\Exception $e) {
                    $this->messageManager->addErrorMessage($e->getMessage()); 
                    return $resultRedirect->setPath('magegetenquiry/grid/');
                }
            }
            else{
                $post_data = $this->getRequest()->getPostValue();
                $Cmessagedata->setData($post_data);
                $Cmessagedata->save();
                $this->messageManager->addSuccess(__("Save Data Successfully"));
                $this->resultPageFactory->create();
                return $resultRedirect->setPath('magegetenquiry/grid/');
            }
        }

            

        } catch(\Exception $e){
            $this->messageManager->addError($e->getMessage());
            $this->_logLoggerInterface->debug($e->getMessage());
            $this->_redirect('enquiry/form/index');
        }
        $this->_redirect('magegetenquiry/grid/index');
    }

    /**
     * @return bool
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('EnquiryForm_Enquiry::save');
    }
}
