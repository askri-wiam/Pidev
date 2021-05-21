<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210426230231 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE cour2 (id INT AUTO_INCREMENT NOT NULL, idf INT DEFAULT NULL, nom VARCHAR(200) NOT NULL, extension VARCHAR(200) NOT NULL, image VARCHAR(200) NOT NULL, INDEX idf (idf), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE cour2 ADD CONSTRAINT FK_FC11FD9A1D074373 FOREIGN KEY (idf) REFERENCES formation (id)');
        $this->addSql('DROP TABLE certification');
        $this->addSql('ALTER TABLE cours DROP FOREIGN KEY cours_ibfk_1');
        $this->addSql('ALTER TABLE cours CHANGE idf idf INT DEFAULT NULL');
        $this->addSql('ALTER TABLE cours ADD CONSTRAINT FK_FDCA8C9C1D074373 FOREIGN KEY (idf) REFERENCES formation (id)');
        $this->addSql('ALTER TABLE formation CHANGE effectif effectif INT DEFAULT NULL');
        $this->addSql('ALTER TABLE participants DROP FOREIGN KEY participants_ibfk_1');
        $this->addSql('ALTER TABLE participants DROP FOREIGN KEY participants_ibfk_2');
        $this->addSql('ALTER TABLE participants DROP FOREIGN KEY participants_ibfk_1');
        $this->addSql('ALTER TABLE participants CHANGE idclient idclient INT DEFAULT NULL, CHANGE idformation idformation INT DEFAULT NULL');
        $this->addSql('ALTER TABLE participants ADD CONSTRAINT FK_716970923E5B884A FOREIGN KEY (idformation) REFERENCES formation (id)');
        $this->addSql('ALTER TABLE participants ADD CONSTRAINT FK_71697092A3F9A9F9 FOREIGN KEY (idclient) REFERENCES utilisateur (id_utilisateur)');
        $this->addSql('DROP INDEX idformation ON participants');
        $this->addSql('CREATE INDEX FK_716970923E5B884A ON participants (idformation)');
        $this->addSql('ALTER TABLE participants ADD CONSTRAINT participants_ibfk_1 FOREIGN KEY (idformation) REFERENCES formation (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE rdv CHANGE id_coach id_coach VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE certification (id INT AUTO_INCREMENT NOT NULL, idf INT NOT NULL, domaine VARCHAR(30) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, grade VARCHAR(10) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, INDEX idfo (idf), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE certification ADD CONSTRAINT certification_ibfk_1 FOREIGN KEY (idf) REFERENCES formation (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('DROP TABLE cour2');
        $this->addSql('ALTER TABLE cours DROP FOREIGN KEY FK_FDCA8C9C1D074373');
        $this->addSql('ALTER TABLE cours CHANGE idf idf INT NOT NULL');
        $this->addSql('ALTER TABLE cours ADD CONSTRAINT cours_ibfk_1 FOREIGN KEY (idf) REFERENCES formation (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE formation CHANGE effectif effectif INT DEFAULT 0 NOT NULL');
        $this->addSql('ALTER TABLE participants DROP FOREIGN KEY FK_716970923E5B884A');
        $this->addSql('ALTER TABLE participants DROP FOREIGN KEY FK_71697092A3F9A9F9');
        $this->addSql('ALTER TABLE participants DROP FOREIGN KEY FK_716970923E5B884A');
        $this->addSql('ALTER TABLE participants CHANGE idformation idformation INT NOT NULL, CHANGE idclient idclient INT NOT NULL');
        $this->addSql('ALTER TABLE participants ADD CONSTRAINT participants_ibfk_1 FOREIGN KEY (idformation) REFERENCES formation (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE participants ADD CONSTRAINT participants_ibfk_2 FOREIGN KEY (idclient) REFERENCES utilisateur (id_utilisateur) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('DROP INDEX fk_716970923e5b884a ON participants');
        $this->addSql('CREATE INDEX idformation ON participants (idformation)');
        $this->addSql('ALTER TABLE participants ADD CONSTRAINT FK_716970923E5B884A FOREIGN KEY (idformation) REFERENCES formation (id)');
        $this->addSql('ALTER TABLE rdv CHANGE id_coach id_coach INT NOT NULL');
    }
}
