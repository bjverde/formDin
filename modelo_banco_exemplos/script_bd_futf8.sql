SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema form_exemplo
-- -----------------------------------------------------
-- banco de dados de exemplo para utilizar o formDin	
DROP SCHEMA IF EXISTS `futf8` ;

-- -----------------------------------------------------
-- Schema form_exemplo
--
-- banco de dados de exemplo para utilizar o formDin	
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `futf8` DEFAULT CHARACTER SET utf8;

-- --------------------------
-- Create user 
-- --------------------------
DROP USER IF EXISTS 'futf8'@'localhost';
CREATE USER 'futf8'@'localhost' IDENTIFIED BY '123456';
GRANT DELETE,EXECUTE,INSERT,SELECT,UPDATE ON futf8.* TO 'futf8'@'localhost';

USE `futf8` ;

-- -----------------------------------------------------
-- Table `form_exemplo`.`pessoa`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `futf8`.`pessoa` (
  `idpessoa` INT NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(200) NOT NULL,
  `tipo` CHAR(2) NOT NULL COMMENT '\'Valor permitidos PF ou PJ\'',
  `dat_inclusao` DATETIME NOT NULL,
  PRIMARY KEY (`idpessoa`))
ENGINE = InnoDB;

INSERT INTO `futf8`.`pessoa` (`nome`,`tipo`,`dat_inclusao`) VALUES ('João T','PF',NOW());
INSERT INTO `futf8`.`pessoa` (`nome`,`tipo`,`dat_inclusao`) VALUES ('Francisco X','PF',NOW());
INSERT INTO `futf8`.`pessoa` (`nome`,`tipo`,`dat_inclusao`) VALUES ('Dell','PJ','1984-04-01 23:59:59');
INSERT INTO `futf8`.`pessoa` (`nome`,`tipo`,`dat_inclusao`) VALUES ('Google','PJ','1998-09-04 23:59:59');
INSERT INTO `futf8`.`pessoa` (`nome`,`tipo`,`dat_inclusao`) VALUES ('incríveis sugestões','PJ',NOW());
INSERT INTO `futf8`.`pessoa` (`nome`,`tipo`,`dat_inclusao`) VALUES ('tarefa não é fácil','PF',NOW());
INSERT INTO `futf8`.`pessoa` (`nome`,`tipo`,`dat_inclusao`) VALUES ('Linux','PJ','1991-04-01 23:59:59');