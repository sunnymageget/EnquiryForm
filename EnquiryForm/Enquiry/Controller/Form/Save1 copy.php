<?php 

namespace EnquiryForm\Enquiry\Controller\Form;

use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\MediaStorage\Model\File\UploaderFactory;
use Magento\Framework\Image\AdapterFactory;
use Magento\Framework\Filesystem; 
use Magento\Framework\App\Action\Context; 
use Magento\Framework\View\Result\PageFactory;
use EnquiryForm\Enquiry\Helper\Data;
class Save extends \Magento\Framework\App\Action\Action
{

    protected $resultPageFactory;
	protected $modelFactory;
	protected $uploaderFactory;
    protected $_mediaDirectory;
    protected $adapterFactory;
    protected $filesystem;
    protected $helperdata;
    public function __construct(

        Context $context,
        PageFactory $resultPageFactory,
		\EnquiryForm\Enquiry\Model\DocumentFactory $modelFactory,
        UploaderFactory $uploaderFactory,
        AdapterFactory $adapterFactory,
        Filesystem $filesystem,
        Data $helperdata
    )
    {
        $this->resultPageFactory = $resultPageFactory;
		$this->modelFactory = $modelFactory;
        $this->uploaderFactory = $uploaderFactory;
        $this->adapterFactory = $adapterFactory;
        $this->filesystem = $filesystem; 
        $this->helperdata = $helperdata; 

        $this->_mediaDirectory = $filesystem->getDirectoryWrite(\Magento\Framework\App\Filesystem\DirectoryList::MEDIA);
        parent::__construct($context);
    }

    public function execute()
    {

        $resultRedirect = $this->resultRedirectFactory->create();

        $data = $this->getRequest()->getParams();
        $this->helperdata->sendMail();
        // die('sunny');
        $object_manager = \Magento\Core\Model\ObjectManager::getInstance();
        $helper_factory = $object_manager->get('\EnquiryForm\Enquiry\Helper');
        $helper = $helper_factory->get('\Magento\Core\Helper\Data');







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


    }

}
?>