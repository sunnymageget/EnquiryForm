<?php
namespace EnquiryForm\Enquiry\Setup;

use Magento\Framework\Setup\UpgradeSchemaInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\ModuleContextInterface;

class UpgradeSchema implements UpgradeSchemaInterface
{
	public function upgrade( SchemaSetupInterface $setup, ModuleContextInterface $context ) {
		$installer = $setup;

		$installer->startSetup();

		if(version_compare($context->getVersion(), '1.1.0')) {
			if (!$installer->tableExists('enquiryform_enquiry_records')) {
				$table = $installer->getConnection()->newTable(
					$installer->getTable('enquiryform_enquiry_records')
				)
				->addColumn(
					'id',
					\Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
					null,
					['identity' => true, 'nullable' => false, 'primary' => true],
					'Record Id'
				)->addColumn(
					'name',
					\Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
					255,
					['nullable' => false],
					'Sender Name'
				)->addColumn(
					'email',
					\Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
					'255',
					['nullable' => false],
					'Sender Email'
				)->addColumn(
					'phonenumber',
					\Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
					'255',
					['nullable' => false],
					'Sender phonenumber'
				)  
				->addColumn(
					'phonenumber',
					\Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
					'255',
					['nullable' => false],
					'Sender phonenumber'
				)  
				->addColumn(
					'dob',
					\Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
					'255',
					['nullable' => false],
					'Sender dob'
				) 
				->addColumn(
					'message',
					 \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
					255,
					['nullable' => false],
					'Message'
				)  
				->addColumn(
					'upload_file',
					\Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
					'255',
					['nullable' => false],
					'upload_file'
				)   
				->addColumn(
					'status',
					\Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
					null,
					['nullable' => false, 'default' => 0],
					'Status'
				)
				->addColumn(
					'created_at',
					\Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
					null,
					['nullable' => false, 'default' => \Magento\Framework\DB\Ddl\Table::TIMESTAMP_INIT],
					'Created At'
				)->addColumn(
					'update_time',
					\Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
					null,
					['nullable' => false, 'default' => \Magento\Framework\DB\Ddl\Table::TIMESTAMP_INIT_UPDATE],
					'Updated At'
				)->setComment(
					'Data Table'
				);
				$installer->getConnection()->createTable($table);

				$installer->getConnection()->addIndex(
					$installer->getTable('EnquiryForm_Enquiry'),
					$setup->getIdxName(
						$installer->getTable('EnquiryForm_Enquiry'),
						['name','email','phonenumber','dob','message','upload_file'],
						\Magento\Framework\DB\Adapter\AdapterInterface::INDEX_TYPE_FULLTEXT
					),
					['name','email','phonenumber','dob','message','upload_file'],
					\Magento\Framework\DB\Adapter\AdapterInterface::INDEX_TYPE_FULLTEXT
				);
			}
		}

		$installer->endSetup();
	}
}