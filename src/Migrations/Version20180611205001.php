<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180611205001 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE user_betting DROP INDEX UNIQ_6D031E8E48FD905, ADD INDEX IDX_6D031E8E48FD905 (game_id)');
        $this->addSql('ALTER TABLE user_betting DROP INDEX UNIQ_6D031E8A76ED395, ADD INDEX IDX_6D031E8A76ED395 (user_id)');
        $this->addSql('ALTER TABLE user_betting CHANGE game_id game_id INT DEFAULT NULL, CHANGE user_id user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE game DROP INDEX UNIQ_232B318C500FBE21, ADD INDEX IDX_232B318C500FBE21 (team_first_id)');
        $this->addSql('ALTER TABLE game DROP INDEX UNIQ_232B318C4893052B, ADD INDEX IDX_232B318C4893052B (team_second_id)');
        $this->addSql('ALTER TABLE game CHANGE team_first_id team_first_id INT DEFAULT NULL, CHANGE team_second_id team_second_id INT DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE game DROP INDEX IDX_232B318C500FBE21, ADD UNIQUE INDEX UNIQ_232B318C500FBE21 (team_first_id)');
        $this->addSql('ALTER TABLE game DROP INDEX IDX_232B318C4893052B, ADD UNIQUE INDEX UNIQ_232B318C4893052B (team_second_id)');
        $this->addSql('ALTER TABLE game CHANGE team_first_id team_first_id INT NOT NULL, CHANGE team_second_id team_second_id INT NOT NULL');
        $this->addSql('ALTER TABLE user_betting DROP INDEX IDX_6D031E8E48FD905, ADD UNIQUE INDEX UNIQ_6D031E8E48FD905 (game_id)');
        $this->addSql('ALTER TABLE user_betting DROP INDEX IDX_6D031E8A76ED395, ADD UNIQUE INDEX UNIQ_6D031E8A76ED395 (user_id)');
        $this->addSql('ALTER TABLE user_betting CHANGE game_id game_id INT NOT NULL, CHANGE user_id user_id INT NOT NULL');
    }
}
