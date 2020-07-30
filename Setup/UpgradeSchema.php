<?php
declare(strict_types=1);

namespace Brandung\Seo\Setup;

use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\UpgradeSchemaInterface;

class UpgradeSchema implements UpgradeSchemaInterface
{
    /**
     * @param SchemaSetupInterface $setup
     * @param ModuleContextInterface $context
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function upgrade(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        if (version_compare($context->getVersion(), '1.1.0') < 0) {
            $connection = $setup->getConnection();
            $connection->addColumn(
                $connection->getTableName('cms_page'),
                'global_identifier',
                [
                    Table::OPTION_TYPE     => Table::TYPE_TEXT,
                    Table::OPTION_LENGTH   => '255',
                    Table::OPTION_NULLABLE => true,
                    'comment'              => 'Global CMS Identifier',
                ]
            );
        }
    }
}
