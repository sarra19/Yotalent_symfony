<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230427154504 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY comment_ibfk_1');
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY comment_ibfk_1');
        $this->addSql('ALTER TABLE comment CHANGE comment comment LONGTEXT NOT NULL');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526CFB2214AE FOREIGN KEY (idest) REFERENCES espacetalent (idEST)');
        $this->addSql('DROP INDEX comment_ibfk_1 ON comment');
        $this->addSql('CREATE INDEX IDX_9474526CFB2214AE ON comment (idest)');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT comment_ibfk_1 FOREIGN KEY (idEst) REFERENCES espacetalent (idEST) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE contrat DROP FOREIGN KEY contrat_ibfk_1');
        $this->addSql('ALTER TABLE contrat DROP FOREIGN KEY contrat_ibfk_1');
        $this->addSql('ALTER TABLE contrat CHANGE DateDC DateDC DATE NOT NULL, CHANGE DateFC DateFC DATE NOT NULL, CHANGE idEST idEST INT DEFAULT NULL');
        $this->addSql('ALTER TABLE contrat ADD CONSTRAINT FK_603499936D855624 FOREIGN KEY (idEST) REFERENCES espacetalent (idEST)');
        $this->addSql('DROP INDEX idest ON contrat');
        $this->addSql('CREATE INDEX IDX_603499936D855624 ON contrat (idEST)');
        $this->addSql('ALTER TABLE contrat ADD CONSTRAINT contrat_ibfk_1 FOREIGN KEY (idEST) REFERENCES espacetalent (idEST) ON UPDATE CASCADE');
        $this->addSql('ALTER TABLE espacetalent CHANGE idU idU INT DEFAULT NULL, CHANGE idCat idCat INT DEFAULT NULL');
        $this->addSql('ALTER TABLE participation CHANGE idEv idEv INT DEFAULT NULL, CHANGE idU idU INT DEFAULT NULL, CHANGE idT idT INT DEFAULT NULL');
        $this->addSql('ALTER TABLE planning CHANGE idEv idEv INT DEFAULT NULL');
        $this->addSql('ALTER TABLE remboursement CHANGE idT idT INT DEFAULT NULL');
        $this->addSql('ALTER TABLE ticket CHANGE idEv idEv INT DEFAULT NULL');
        $this->addSql('ALTER TABLE video DROP FOREIGN KEY video_ibfk_1');
        $this->addSql('ALTER TABLE video CHANGE idEST idEST INT DEFAULT NULL');
        $this->addSql('ALTER TABLE video ADD CONSTRAINT FK_7CC7DA2C6D855624 FOREIGN KEY (idEST) REFERENCES espacetalent (idEST)');
        $this->addSql('ALTER TABLE voyage CHANGE dateDVoy dateDVoy DATE NOT NULL, CHANGE dateRVoy dateRVoy DATE NOT NULL, CHANGE idC idC INT DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE messenger_messages');
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526CFB2214AE');
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526CFB2214AE');
        $this->addSql('ALTER TABLE comment CHANGE comment comment TEXT NOT NULL');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT comment_ibfk_1 FOREIGN KEY (idEst) REFERENCES espacetalent (idEST) ON DELETE CASCADE');
        $this->addSql('DROP INDEX idx_9474526cfb2214ae ON comment');
        $this->addSql('CREATE INDEX comment_ibfk_1 ON comment (idEst)');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526CFB2214AE FOREIGN KEY (idest) REFERENCES espacetalent (idEST)');
        $this->addSql('ALTER TABLE contrat DROP FOREIGN KEY FK_603499936D855624');
        $this->addSql('ALTER TABLE contrat DROP FOREIGN KEY FK_603499936D855624');
        $this->addSql('ALTER TABLE contrat CHANGE DateDC DateDC VARCHAR(255) NOT NULL, CHANGE DateFC DateFC VARCHAR(255) NOT NULL, CHANGE idEST idEST INT NOT NULL');
        $this->addSql('ALTER TABLE contrat ADD CONSTRAINT contrat_ibfk_1 FOREIGN KEY (idEST) REFERENCES espacetalent (idEST) ON UPDATE CASCADE');
        $this->addSql('DROP INDEX idx_603499936d855624 ON contrat');
        $this->addSql('CREATE INDEX idEST ON contrat (idEST)');
        $this->addSql('ALTER TABLE contrat ADD CONSTRAINT FK_603499936D855624 FOREIGN KEY (idEST) REFERENCES espacetalent (idEST)');
        $this->addSql('ALTER TABLE espacetalent CHANGE idCat idCat INT NOT NULL, CHANGE idU idU INT NOT NULL');
        $this->addSql('ALTER TABLE participation CHANGE idT idT INT NOT NULL, CHANGE idEv idEv INT NOT NULL, CHANGE idU idU INT NOT NULL');
        $this->addSql('ALTER TABLE planning CHANGE idEv idEv INT NOT NULL');
        $this->addSql('ALTER TABLE remboursement CHANGE idT idT INT NOT NULL');
        $this->addSql('ALTER TABLE ticket CHANGE idEv idEv INT NOT NULL');
        $this->addSql('ALTER TABLE video DROP FOREIGN KEY FK_7CC7DA2C6D855624');
        $this->addSql('ALTER TABLE video CHANGE idEST idEST INT NOT NULL');
        $this->addSql('ALTER TABLE video ADD CONSTRAINT video_ibfk_1 FOREIGN KEY (idEST) REFERENCES espacetalent (idEST) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE voyage CHANGE dateDVoy dateDVoy VARCHAR(255) NOT NULL, CHANGE dateRVoy dateRVoy VARCHAR(255) NOT NULL, CHANGE idC idC INT NOT NULL');
    }
}
