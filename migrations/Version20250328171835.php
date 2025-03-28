<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250328171835 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE appartenance (user_id INTEGER NOT NULL, pays_id INTEGER NOT NULL, PRIMARY KEY(user_id), CONSTRAINT FK_B1E34A6BA76ED395 FOREIGN KEY (user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_B1E34A6BA6E44244 FOREIGN KEY (pays_id) REFERENCES pays (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_B1E34A6BA6E44244 ON appartenance (pays_id)');
        $this->addSql('CREATE TABLE l3_produit (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, libelle VARCHAR(100) NOT NULL, prix DOUBLE PRECISION DEFAULT NULL, quantite_en_stock INTEGER DEFAULT NULL, enstock BOOLEAN DEFAULT 1 NOT NULL)');
        $this->addSql('CREATE TABLE panier (user_id INTEGER NOT NULL, produit_id INTEGER DEFAULT NULL, quantite INTEGER DEFAULT NULL, PRIMARY KEY(user_id), CONSTRAINT FK_24CC0DF2A76ED395 FOREIGN KEY (user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_24CC0DF2F347EFB FOREIGN KEY (produit_id) REFERENCES l3_produit (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_24CC0DF2F347EFB ON panier (produit_id)');
        $this->addSql('CREATE TABLE pays (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, nom VARCHAR(50) NOT NULL)');
        $this->addSql('CREATE TABLE test (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE appartenance');
        $this->addSql('DROP TABLE l3_produit');
        $this->addSql('DROP TABLE panier');
        $this->addSql('DROP TABLE pays');
        $this->addSql('DROP TABLE test');
    }
}
