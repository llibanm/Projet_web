<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250325142012 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__appartenance AS SELECT user_id, pays_id FROM appartenance');
        $this->addSql('DROP TABLE appartenance');
        $this->addSql('CREATE TABLE appartenance (user_id INTEGER NOT NULL, pays_id INTEGER NOT NULL, PRIMARY KEY(user_id), CONSTRAINT FK_B1E34A6BA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_B1E34A6BA6E44244 FOREIGN KEY (pays_id) REFERENCES pays (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO appartenance (user_id, pays_id) SELECT user_id, pays_id FROM __temp__appartenance');
        $this->addSql('DROP TABLE __temp__appartenance');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_B1E34A6BA6E44244 ON appartenance (pays_id)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__panier AS SELECT user_id, produit_id FROM panier');
        $this->addSql('DROP TABLE panier');
        $this->addSql('CREATE TABLE panier (user_id INTEGER NOT NULL, produit_id INTEGER DEFAULT NULL, quantite INTEGER DEFAULT NULL, PRIMARY KEY(user_id), CONSTRAINT FK_24CC0DF2A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_24CC0DF2F347EFB FOREIGN KEY (produit_id) REFERENCES produit (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO panier (user_id, produit_id) SELECT user_id, produit_id FROM __temp__panier');
        $this->addSql('DROP TABLE __temp__panier');
        $this->addSql('CREATE INDEX IDX_24CC0DF2F347EFB ON panier (produit_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__appartenance AS SELECT user_id, pays_id FROM appartenance');
        $this->addSql('DROP TABLE appartenance');
        $this->addSql('CREATE TABLE appartenance (user_id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, pays_id INTEGER NOT NULL, CONSTRAINT FK_B1E34A6BA76ED395 FOREIGN KEY (user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_B1E34A6BA6E44244 FOREIGN KEY (pays_id) REFERENCES pays (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO appartenance (user_id, pays_id) SELECT user_id, pays_id FROM __temp__appartenance');
        $this->addSql('DROP TABLE __temp__appartenance');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_B1E34A6BA6E44244 ON appartenance (pays_id)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__panier AS SELECT user_id, produit_id FROM panier');
        $this->addSql('DROP TABLE panier');
        $this->addSql('CREATE TABLE panier (user_id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, produit_id INTEGER DEFAULT NULL, CONSTRAINT FK_24CC0DF2A76ED395 FOREIGN KEY (user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_24CC0DF2F347EFB FOREIGN KEY (produit_id) REFERENCES produit (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO panier (user_id, produit_id) SELECT user_id, produit_id FROM __temp__panier');
        $this->addSql('DROP TABLE __temp__panier');
        $this->addSql('CREATE INDEX IDX_24CC0DF2F347EFB ON panier (produit_id)');
    }
}
