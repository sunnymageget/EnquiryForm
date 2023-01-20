<?php

namespace EnquiryForm\Enquiry\Model;

use EnquiryForm\Enquiry\Api\Data\GridInterface;

class Grid extends \Magento\Framework\Model\AbstractModel implements GridInterface
{
   
    const CACHE_TAG = 'EnquiryForm_Enquiry_records';

    
    protected $_cacheTag = 'EnquiryForm_Enquiry_records';

    
    protected $_eventPrefix = 'EnquiryForm_Enquiry_records';

    
    protected function _construct()
    {
        $this->_init('EnquiryForm\Enquiry\Model\ResourceModel\Grid');
    }
   
    public function getEntityId()
    {
        return $this->getData(self::ENTITY_ID);
    }

   
    public function setEntityId($Id)
    {
        return $this->setData(self::ENTITY_ID, $Id);
    }

   
    public function getName()
    {
        return $this->getData(self::NAME);
    }

    
    public function setName($name)
    {
        return $this->setData(self::NAME, $name);
    }
    
    public function getEmail()
    {
        return $this->getData(self::EMAIL);
    }

    
    public function setEmail($email)
    {
        return $this->setData(self::EMAIL, $email);
    }
  
    public function getPhonenumber()
    {
        return $this->getData(self::PHONENUMBER);
    }

   
    public function setPhonenumber($phonenumber)
    {
        return $this->setData(self::PHONENUMBER, $phonenumber);
    }


    public function getdob()
    {
        return $this->getData(self::DOB);
    }

    
    public function setDob($dob)
    {
        return $this->setData(self::DOB, $dob);
    }
    
    public function getMessage()
    {
        return $this->getData(self::MESSAGE);
    }

    public function setMessage($Message)
    {
        return $this->setData(self::MESSAGE, $Message);
    }

   
    public function getCreatedAt()
    {
        return $this->getData(self::CREATED_AT);
    }

    
    public function setCreatedAt($createdAt)
    {
        return $this->setData(self::CREATED_AT, $createdAt);
    }
    
    // public function getUpdateTime()
    // {
    //     return $this->getData(self::UPDATE_TIME);
    // }
    
    public function getUploadFile(){
        return $this->getData(self::UPLOAD_FILE);
    }

    public function setUploadFile($image)
    {
        return $this->setData(self::UPLOAD_FILE, $image);
    }

    public function getIsActive(){
        return $this->getData(self::IS_ACTIVE);
    }

    public function setIsActive($isActive)
    {
        return $this->setData(self::IS_ACTIVE, $isActive);
    }
}