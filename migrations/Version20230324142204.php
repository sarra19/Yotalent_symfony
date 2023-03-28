<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230324142204 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE espacetalent CHANGE idU idU INT DEFAULT NULL, CHANGE idVid idVid INT DEFAULT NULL, CHANGE idCat idCat INT DEFAULT NULL, CHANGE idC idC INT DEFAULT NULL');
        $this->addSql('ALTER TABLE participation CHANGE idEv idEv INT DEFAULT NULL, CHANGE idU idU INT DEFAULT NULL, CHANGE idT idT INT DEFAULT NULL');
        $this->addSql('ALTER TABLE planning CHANGE idEv idEv INT DEFAULT NULL');
        $this->addSql('ALTER TABLE remboursement CHANGE idT idT INT DEFAULT NULL');
        $this->addSql('ALTER TABLE ticket CHANGE idEv idEv INT DEFAULT NULL');
        $this->addSql('ALTER TABLE vote CHANGE idU idU INT DEFAULT NULL, CHANGE idEV idEV INT DEFAULT NULL, CHANGE idEST idEST INT DEFAULT NULL');
        $this->addSql('ALTER TABLE voyage CHANGE idC idC INT DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE messenger_messages');
        $this->addSql('ALTER TABLE espacetalent CHANGE idVid idVid INT NOT NULL, CHANGE idCat idCat INT NOT NULL, CHANGE idU idU INT NOT NULL, CHANGE idC idC INT NOT NULL');
        $this->addSql('ALTER TABLE participation CHANGE idEv idEv INT NOT NULL, CHANGE idU idU INT NOT NULL, CHANGE idT idT INT NOT NULL');
        $this->addSql('ALTER TABLE planning CHANGE idEv idEv INT NOT NULL');
        $this->addSql('ALTER TABLE remboursement CHANGE idT idT INT NOT NULL');
        $this->addSql('ALTER TABLE ticket CHANGE idEv idEv INT NOT NULL');
        $this->addSql('ALTER TABLE vote CHANGE idU idU INT NOT NULL, CHANGE idEV idEV INT NOT NULL, CHANGE idEST idEST INT NOT NULL');
        $this->addSql('ALTER TABLE voyage CHANGE idC idC INT NOT NULL');
    }
}
