<?php

namespace EnquiryForm\Enquiry\Api\Data;

interface GridInterface
{
    
    const ENTITY_ID = 'id';
    const NAME = 'name';
    const EMAIL = 'email';
    const PHONENUMBER = 'phone_no';
    const DOB = 'dob';
    const MESSAGE = 'message';
    const IS_ACTIVE = 'is_active';
    const CREATED_AT = 'created_at';
    const UPLOAD_FILE = 'upload_file';

   /**
    * Get EntityId.
    *
    * @return int
    */
    public function getEntityId();

   
    public function setEntityId($entityId);

   /**
    * Get Title.
    *
    * @return varchar
    */
    public function getName();

   
    public function setName($name);

    /**
     * Get getContent.
     *
     * @return varchar
     */
    public function getEmail();

    
    public function setEmail($email);

    public function getPhonenumber();
    
    public function setPhonenumber($phone_no);

    public function getDob();
    
    public function setDob($dob);


    public function getMessage();
    
    public function setMessage($message);


   /**
    * Get IsActive.
    *
    * @return varchar
    */
    public function getIsActive();

   
    public function setIsActive($isActive);

   /**
    * Get UpdateTime.
    *
    * @return varchar
    */
    // public function getUpdateTime();

   
    // public function setUpdateTime($updateTime);

   /**
    * Get CreatedAt.
    *
    * @return varchar
    */
    public function getCreatedAt();

    public function setCreatedAt($createdAt);


    /**
    * Get upload_file.
    *
    * @return varchar
    */
    public function getUploadFile();

    public function setUploadFile($upload_file);
}
