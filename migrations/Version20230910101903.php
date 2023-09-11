<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230910101903 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $countryTable = $schema->createTable('country');
        $countryTable->addColumn('id', 'integer', ['autoincrement' => true]);
        $countryTable->addColumn('name', 'string', ['length' => 255]);
        $countryTable->addColumn('regex_tax_number', 'string', ['length' => 255]);
        $countryTable->addColumn('tax_percentage', 'float');
        $countryTable->setPrimaryKey(['id']);

        $couponTable = $schema->createTable('coupon');
        $couponTable->addColumn('id', 'integer', ['autoincrement' => true]);
        $couponTable->addColumn('code', 'string', ['length' => 255]);
        $couponTable->addColumn('type', 'string', ['length' => 255]);
        $couponTable->addColumn('value', 'integer');
        $couponTable->addColumn('is_active', 'boolean');
        $couponTable->setPrimaryKey(['id']);

        $productTable = $schema->createTable('product');
        $productTable->addColumn('id', 'integer', ['autoincrement' => true]);
        $productTable->addColumn('name', 'string', ['length' => 255]);
        $productTable->addColumn('price', 'integer');
        $productTable->setPrimaryKey(['id']);
    }

    public function down(Schema $schema): void
    {
        $schema->dropTable('product');
        $schema->dropTable('payment_service');
        $schema->dropTable('coupon');
        $schema->dropTable('country');
    }
}
