<?php
namespace EnquiryForm\Enquiry\Plugin;

class HistoryPlugin
{
    /**
     * @var \Magento\Framework\App\Action\Context
     */
    private $context;
    private  $response;
    private  $redirect;
    /**
     * @var \Magento\Framework\UrlInterface
     */
    private $url;


    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\UrlInterface $url
    )
    {
        $this->context = $context;
        $this->response = $context->getResponse();
        $this->redirect = $context->getRedirect();

        $this->url = $url;
    }

    public function aroundExecute(
        \Magento\Sales\Controller\Order\History $object,
        callable $proceed
    ){

        $norouteUrl = $this->url->getUrl('noroute');
        $this->getResponse()->setRedirect($norouteUrl);
        return;
    }
    /**
     * Retrieve response object
     *
     * @return \Magento\Framework\App\ResponseInterface
     */
    public function getResponse()
    {
        return $this->response;
    }
}


// class Noroute
// {
//     private $redirectFactory;

//     public function __construct(\Magento\Framework\Controller\Result\RedirectFactory $redirectFactory)
//     {
//         $this->redirectFactory = $redirectFactory;
//     }

//     public function aroundExecute(
//         \Magento\Cms\Controller\Noroute\Index $index,
//         \Closure $proceed
//     ) {
//         return $this->redirectFactory->create()
//                     ->setPath('404notfound');
//     }
// }