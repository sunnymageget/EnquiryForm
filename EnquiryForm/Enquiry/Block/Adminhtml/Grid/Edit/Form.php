<?php

namespace EnquiryForm\Enquiry\Block\Adminhtml\Grid\Edit;

class Form extends \Magento\Backend\Block\Widget\Form\Generic
{
    /**
     * @var \Magento\Store\Model\System\Store
     */
    protected $_systemStore;
    protected $_coreRegistry = null;
    /**
     * @param \Magento\Backend\Block\Template\Context $context,
     * @param \Magento\Framework\Registry $registry,
     * @param \Magento\Framework\Data\FormFactory $formFactory,
     * @param \Magento\Cms\Model\Wysiwyg\Config $wysiwygConfig,
     * @param \Webkul\Grid\Model\Status $options,
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Data\FormFactory $formFactory,
        \Magento\Cms\Model\Wysiwyg\Config $wysiwygConfig,
        \EnquiryForm\Enquiry\Model\Status $options,
        array $data = []
    ) {
        $this->_options = $options;
        $this->_wysiwygConfig = $wysiwygConfig;
        $this->_coreRegistry = $registry;
        parent::__construct($context, $registry, $formFactory, $data);
    }

    /**
     * Prepare form.
     *
     * @return $this  
     */
    protected function _prepareForm()
    {
        $dateFormat = $this->_localeDate->getDateFormat(\IntlDateFormatter::SHORT);
        $model = $this->_coreRegistry->registry('row_data');
        // echo "<pre>";
        // print_r($model->getData());
        // die("mageget");
        $form = $this->_formFactory->create(
            ['data' => [
                            'id' => 'edit_form',
                            'enctype' => 'multipart/form-data',
                            'action' => $this->getData('action'),
                            'method' => 'post'
                        ]
            ]
        );

        $form->setHtmlIdPrefix('wkgrid_');
        if ($model->getEntityId()) {
            $fieldset = $form->addFieldset(
                'base_fieldset',
                ['legend' => __('Edit Row Data'), 'class' => 'fieldset-wide']
            );
            $fieldset->addField('id', 'hidden', ['name' => 'id']);
        } else {
            $fieldset = $form->addFieldset(
                'base_fieldset',
                ['legend' => __('Add Row Data'), 'class' => 'fieldset-wide']
            );
        }
       
        $fieldset->addField(
            'name',
            'text',
            [
                'name' => 'name',
                'label' => __('Name'),
                'id' => 'name',
                'title' => __('Name'),
                'class' => 'required-entry',
                'required' => true,
            ]
        );

        $fieldset->addField(
            'email',
            'text',
            [
                'name' => 'email',
                'label' => __('Email'),
                'id' => 'email',
                'title' => __('Email'),
                'class' => 'required-entry',
                'required' => true,
            ]
        );

        $fieldset->addField(
            'phonenumber',
            'text',
            [
                'name' => 'phonenumber',
                'label' => __('Phone No'),
                'id' => 'phonenumber',
                'title' => __('Phone No'),
                'class' => 'required-entry',
                'required' => true,
            ]
        );

        $fieldset->addField(
            'message',
            'text',
            [
                'name' => 'message',
                'label' => __('Message'),
                'id' => 'message',
                'title' => __('Message'),
                'class' => 'required-entry',
                'required' => true,
            ]
        );
        $fieldset->addField(
            'dob',
            'text',
            [
                'name' => 'dob',
                'label' => __('Date of Birth'),
                'id' => 'dob',
                'title' => __('dob'),
                'class' => 'required-entry',
                'required' => true,
            ]
        );



        $fieldset->addField(
            'upload_file',
            'file',
            [
                'name' => 'upload_file',
                'label' => __('image'),
                'id' => 'image',
                'title' => __('image'),
                // 'class' => 'required-entry',
                // 'required' => true,
            ]
        );


        // $fieldset->addField(
        //     'created_at',
        //     'text',
        //     [
        //         'name' => 'created_at',
        //         'label' => __('Created at'),
        //         'id' => 'name',
        //         'title' => __('Phone No'),
        //         'class' => 'required-entry',
        //         'required' => true,
        //     ]
        // );


        $wysiwygConfig = $this->_wysiwygConfig->getConfig(['tab_id' => $this->getTabId()]);

        // $fieldset->addField(
        //     'content',
        //     'editor',
        //     [
        //         'name' => 'content',
        //         'label' => __('Content'),
        //         'style' => 'height:36em;',
        //         'required' => true,
        //         'config' => $wysiwygConfig
        //     ]
        // );

        // $fieldset->addField(
        //     'publish_date',
        //     'date',
        //     [
        //         'name' => 'publish_date',
        //         'label' => __('Publish Date'),
        //         'date_format' => $dateFormat,
        //         'time_format' => 'H:mm:ss',
        //         'class' => 'validate-date validate-date-range date-range-custom_theme-from',
        //         'class' => 'required-entry',
        //         'style' => 'width:200px',
        //     ]
        // );
        // $fieldset->addField(
        //     'is_active',
        //     'select',
        //     [
        //         'name' => 'is_active',
        //         'label' => __('Status'),
        //         'id' => 'is_active',
        //         'title' => __('Status'),
        //         'values' => $this->_options->getOptionArray(),
        //         'class' => 'status',
        //         'required' => true,
        //     ]
        // );
        $form->setValues($model->getData());
        $form->setUseContainer(true);
        $this->setForm($form);

        return parent::_prepareForm();
    }
}
