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
DROP TABLE IF EXISTS `futf8`.`pessoa`;
CREATE TABLE IF NOT EXISTS `futf8`.`pessoa` (
  `idpessoa` INT NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(200) NOT NULL,
  `tipo` CHAR(2) NOT NULL COMMENT 'Valor permitidos PF ou PJ',
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


-- -----------------------------------------------------
-- Table `futf8`.`regiao`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `futf8`.`uf`;
DROP TABLE IF EXISTS `futf8`.`regiao`;
CREATE TABLE IF NOT EXISTS `futf8`.`regiao` (
  `cod_regiao` INT NOT NULL,
  `nom_regiao` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`cod_regiao`))
ENGINE = InnoDB;

INSERT INTO `futf8`.`regiao` (`cod_regiao`,`nom_regiao`) VALUES (1,'Norte');
INSERT INTO `futf8`.`regiao` (`cod_regiao`,`nom_regiao`) VALUES (2,'Nordeste');
INSERT INTO `futf8`.`regiao` (`cod_regiao`,`nom_regiao`) VALUES (3,'Sudeste');
INSERT INTO `futf8`.`regiao` (`cod_regiao`,`nom_regiao`) VALUES (4,'Centro-Oeste');
INSERT INTO `futf8`.`regiao` (`cod_regiao`,`nom_regiao`) VALUES (5,'Sul');
INSERT INTO `futf8`.`regiao` (`cod_regiao`,`nom_regiao`) VALUES (9,'Brasil Todos');


-- -----------------------------------------------------
-- Table `futf8`.`uf`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `futf8`.`uf`;
CREATE TABLE IF NOT EXISTS `futf8`.`uf` (
  `cod_uf` INT NOT NULL,
  `nom_uf` VARCHAR(45) NOT NULL,
  `sig_uf` VARCHAR(45) NOT NULL COMMENT 'sigla da uf',
  `cod_regiao` INT NOT NULL,
  PRIMARY KEY (`cod_uf`),
  INDEX `fk_uf_regiao1_idx` (`cod_regiao` ASC),
  CONSTRAINT `fk_uf_regiao1`
    FOREIGN KEY (`cod_regiao`)
    REFERENCES `futf8`.`regiao` (`cod_regiao`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


INSERT INTO `futf8`.`uf` (cod_uf,sig_uf,nom_uf,cod_regiao) VALUES (11,'RO','RONDONIA',1);
INSERT INTO `futf8`.`uf` (cod_uf,sig_uf,nom_uf,cod_regiao) VALUES (12,'AC','ACRE',1);
INSERT INTO `futf8`.`uf` (cod_uf,sig_uf,nom_uf,cod_regiao) VALUES (13,'AM','AMAZONAS',1);
INSERT INTO `futf8`.`uf` (cod_uf,sig_uf,nom_uf,cod_regiao) VALUES (14,'RR','RORAIMA',1);
INSERT INTO `futf8`.`uf` (cod_uf,sig_uf,nom_uf,cod_regiao) VALUES (15,'PA','PARA',1);
INSERT INTO `futf8`.`uf` (cod_uf,sig_uf,nom_uf,cod_regiao) VALUES (16,'AP','AMAPA',1);
INSERT INTO `futf8`.`uf` (cod_uf,sig_uf,nom_uf,cod_regiao) VALUES (17,'TO','TOCANTINS',1);
INSERT INTO `futf8`.`uf` (cod_uf,sig_uf,nom_uf,cod_regiao) VALUES (21,'MA','MARANHAO',2);
INSERT INTO `futf8`.`uf` (cod_uf,sig_uf,nom_uf,cod_regiao) VALUES (22,'PI','PIAUI',2);
INSERT INTO `futf8`.`uf` (cod_uf,sig_uf,nom_uf,cod_regiao) VALUES (23,'CE','CEARA',2);
INSERT INTO `futf8`.`uf` (cod_uf,sig_uf,nom_uf,cod_regiao) VALUES (24,'RN','RIO GRANDE DO NORTE',2);
INSERT INTO `futf8`.`uf` (cod_uf,sig_uf,nom_uf,cod_regiao) VALUES (25,'PB','PARAIBA',2);
INSERT INTO `futf8`.`uf` (cod_uf,sig_uf,nom_uf,cod_regiao) VALUES (26,'PE','PERNAMBUCO',2);
INSERT INTO `futf8`.`uf` (cod_uf,sig_uf,nom_uf,cod_regiao) VALUES (27,'AL','ALAGOAS',2);
INSERT INTO `futf8`.`uf` (cod_uf,sig_uf,nom_uf,cod_regiao) VALUES (28,'SE','SERGIPE',2);
INSERT INTO `futf8`.`uf` (cod_uf,sig_uf,nom_uf,cod_regiao) VALUES (29,'BA','BAHIA',2);
INSERT INTO `futf8`.`uf` (cod_uf,sig_uf,nom_uf,cod_regiao) VALUES (31,'MG','MINAS GERAIS',3);
INSERT INTO `futf8`.`uf` (cod_uf,sig_uf,nom_uf,cod_regiao) VALUES (32,'ES','ESPIRITO SANTO',3);
INSERT INTO `futf8`.`uf` (cod_uf,sig_uf,nom_uf,cod_regiao) VALUES (33,'RJ','RIO DE JANEIRO',3);
INSERT INTO `futf8`.`uf` (cod_uf,sig_uf,nom_uf,cod_regiao) VALUES (35,'SP','SAO PAULO',3);
INSERT INTO `futf8`.`uf` (cod_uf,sig_uf,nom_uf,cod_regiao) VALUES (41,'PR','PARANA',4);
INSERT INTO `futf8`.`uf` (cod_uf,sig_uf,nom_uf,cod_regiao) VALUES (42,'SC','SANTA CATARINA',4);
INSERT INTO `futf8`.`uf` (cod_uf,sig_uf,nom_uf,cod_regiao) VALUES (43,'RS','RIO GRANDE DO SUL',4);
INSERT INTO `futf8`.`uf` (cod_uf,sig_uf,nom_uf,cod_regiao) VALUES (50,'MS','MATO GROSSO DO SUL',4);
INSERT INTO `futf8`.`uf` (cod_uf,sig_uf,nom_uf,cod_regiao) VALUES (51,'MT','MATO GROSSO',4);
INSERT INTO `futf8`.`uf` (cod_uf,sig_uf,nom_uf,cod_regiao) VALUES (52,'GO','GOIÁS',4);
INSERT INTO `futf8`.`uf` (cod_uf,sig_uf,nom_uf,cod_regiao) VALUES (53,'DF','DISTRITO FEDERAL',4);
INSERT INTO `futf8`.`uf` (cod_uf,sig_uf,nom_uf,cod_regiao) VALUES (99,'UC','Unico',9);



CREATE VIEW regiao_uf AS
select 
	 r.cod_regiao
    ,r.nom_regiao
    ,uf.cod_uf
    ,uf.nom_uf
    ,uf.sig_uf
FROM futf8.regiao as r
    ,futf8.uf as uf
where r.cod_regiao = uf.cod_regiao; 