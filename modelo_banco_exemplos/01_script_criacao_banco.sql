-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema form_exemplo
-- -----------------------------------------------------
-- banco de dados de exemplo para utilizar o formDin	
DROP SCHEMA IF EXISTS `form_exemplo` ;

-- -----------------------------------------------------
-- Schema form_exemplo
--
-- banco de dados de exemplo para utilizar o formDin	
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `form_exemplo` DEFAULT CHARACTER SET utf8 COLLATE utf8_bin ;
USE `form_exemplo` ;

-- -----------------------------------------------------
-- Table `pessoa`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `pessoa` ;

CREATE TABLE IF NOT EXISTS `pessoa` (
  `idpessoa` INT NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(200) NOT NULL,
  `tipo` CHAR(2) NOT NULL COMMENT '\'Valor permitidos PF ou PJ\'',
  `sit_ativo` VARCHAR(1) NOT NULL DEFAULT 'S',
  `dat_inclusao` DATETIME NOT NULL DEFAULT NOW() COMMENT 'Data da inclusão de uma pessoa',
  `dat_alteracao` DATETIME NULL DEFAULT now() ON UPDATE now() COMMENT 'Data da alteração do registro da pessoa',
  PRIMARY KEY (`idpessoa`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `meta_tipo`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `meta_tipo` ;

CREATE TABLE IF NOT EXISTS `meta_tipo` (
  `idMetaTipo` INT NOT NULL AUTO_INCREMENT,
  `descricao` VARCHAR(100) NOT NULL,
  `sit_ativo` CHAR(1) NULL DEFAULT 'S',
  PRIMARY KEY (`idMetaTipo`),
  UNIQUE INDEX `descricao_UNIQUE` (`descricao` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `tipo`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `tipo` ;

CREATE TABLE IF NOT EXISTS `tipo` (
  `idtipo` INT NOT NULL AUTO_INCREMENT,
  `descricao` VARCHAR(100) NOT NULL,
  `idmeta_tipo` INT NOT NULL,
  `sit_ativo` CHAR(1) NULL,
  PRIMARY KEY (`idtipo`),
  INDEX `fk_tipo_tipo_de_tipos_idx` (`idmeta_tipo` ASC),
  CONSTRAINT `fk_tipo_tipo_de_tipos`
    FOREIGN KEY (`idmeta_tipo`)
    REFERENCES `meta_tipo` (`idMetaTipo`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `regiao`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `regiao` ;

CREATE TABLE IF NOT EXISTS `regiao` (
  `cod_regiao` INT NOT NULL,
  `nom_regiao` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`cod_regiao`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `uf`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `uf` ;

CREATE TABLE IF NOT EXISTS `uf` (
  `cod_uf` INT NOT NULL,
  `nom_uf` VARCHAR(45) NOT NULL,
  `sig_uf` VARCHAR(45) NOT NULL COMMENT 'sigla da uf',
  `cod_regiao` INT NOT NULL,
  PRIMARY KEY (`cod_uf`),
  INDEX `fk_uf_regiao1_idx` (`cod_regiao` ASC),
  CONSTRAINT `fk_uf_regiao1`
    FOREIGN KEY (`cod_regiao`)
    REFERENCES `regiao` (`cod_regiao`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `municipio`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `municipio` ;

CREATE TABLE IF NOT EXISTS `municipio` (
  `cod_municipio` INT NOT NULL,
  `cod_uf` INT NOT NULL,
  `nom_municipio` VARCHAR(200) NOT NULL,
  `sit_ativo` VARCHAR(1) NOT NULL DEFAULT 'S',
  PRIMARY KEY (`cod_municipio`),
  INDEX `fk_municipio_uf1_idx` (`cod_uf` ASC),
  CONSTRAINT `fk_municipio_uf1`
    FOREIGN KEY (`cod_uf`)
    REFERENCES `uf` (`cod_uf`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `autoridade`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `autoridade` ;

CREATE TABLE IF NOT EXISTS `autoridade` (
  `idautoridade` INT NOT NULL AUTO_INCREMENT,
  `dat_inclusao` DATETIME NOT NULL DEFAULT now(),
  `dat_evento` DATE NOT NULL COMMENT 'Data do evento',
  `ordem` INT NOT NULL COMMENT 'ordem daa autoridades',
  `cargo` VARCHAR(100) NOT NULL COMMENT 'nome do cargo da autoridade',
  `nome_pessoa` VARCHAR(100) NOT NULL COMMENT 'nome da pessoa',
  PRIMARY KEY (`idautoridade`))
ENGINE = InnoDB
COMMENT = 'Tabela idependete de qualquer outra do sistema';


-- -----------------------------------------------------
-- Table `pessoa_fisica`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `pessoa_fisica` ;

CREATE TABLE IF NOT EXISTS `pessoa_fisica` (
  `idpessoa_fisica` INT NOT NULL AUTO_INCREMENT,
  `idpessoa` INT NOT NULL,
  `cpf` VARCHAR(11) NOT NULL,
  `rg` VARCHAR(45) NULL COMMENT 'Registro Geral, muda de estado para estado. Uma pessoa pode ter mais de um porém geralmente tem apenas um',
  `dat_nascimento` DATE NULL,
  `cod_municipio_nascimento` INT NULL,
  `dat_inclusao` DATETIME NOT NULL DEFAULT NOW(),
  `dat_alteracao` DATETIME NULL DEFAULT now() ON UPDATE now(),
  PRIMARY KEY (`idpessoa_fisica`),
  UNIQUE INDEX `cpf_UNIQUE` (`cpf` ASC),
  INDEX `fk_pessoa_fisica_pessoa1_idx` (`idpessoa` ASC),
  INDEX `fk_pessoa_fisica_municipio1_idx` (`cod_municipio_nascimento` ASC),
  CONSTRAINT `fk_pessoa_fisica_pessoa1`
    FOREIGN KEY (`idpessoa`)
    REFERENCES `pessoa` (`idpessoa`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_pessoa_fisica_municipio1`
    FOREIGN KEY (`cod_municipio_nascimento`)
    REFERENCES `municipio` (`cod_municipio`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `acesso_user`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `acesso_user` ;

CREATE TABLE IF NOT EXISTS `acesso_user` (
  `iduser` INT NOT NULL AUTO_INCREMENT,
  `login_user` VARCHAR(50) NOT NULL,
  `pwd_user` VARCHAR(200) NULL COMMENT 'senha criptografada com password_hash',
  `sit_ativo` VARCHAR(1) NOT NULL DEFAULT 'S',
  `dat_inclusao` DATETIME NOT NULL DEFAULT NOW(),
  `dat_update` DATETIME NULL DEFAULT now() ON UPDATE now(),
  `idpessoa` INT NULL,
  PRIMARY KEY (`iduser`),
  UNIQUE INDEX `nom_usuario_UNIQUE` (`login_user` ASC),
  INDEX `fk_acesso_user_pessoa1_idx` (`idpessoa` ASC),
  CONSTRAINT `fk_acesso_user_pessoa1`
    FOREIGN KEY (`idpessoa`)
    REFERENCES `pessoa` (`idpessoa`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `acesso_perfil`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `acesso_perfil` ;

CREATE TABLE IF NOT EXISTS `acesso_perfil` (
  `idperfil` INT NOT NULL AUTO_INCREMENT,
  `nom_perfil` VARCHAR(45) NOT NULL,
  `sit_ativo` VARCHAR(1) NOT NULL DEFAULT 'S',
  `dat_inclusao` DATETIME NOT NULL DEFAULT NOW(),
  `dat_update` DATETIME NULL DEFAULT now() ON UPDATE now(),
  PRIMARY KEY (`idperfil`),
  UNIQUE INDEX `nom_perfil_UNIQUE` (`nom_perfil` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `acesso_menu`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `acesso_menu` ;

CREATE TABLE IF NOT EXISTS `acesso_menu` (
  `idmenu` INT NOT NULL,
  `nom_menu` VARCHAR(45) NOT NULL COMMENT 'o nome que o usuario irá ver',
  `idmenu_pai` INT NULL COMMENT 'id do menu pai, se o pai é null então começa na raiz',
  `url` VARCHAR(300) NULL COMMENT 'caminho do item de menu',
  `tooltip` VARCHAR(300) NULL COMMENT 'decrição mais detalhada do menu',
  `img_menu` VARCHAR(45) NULL COMMENT 'Caminho da imagem será utilizada como ícone',
  `imgdisabled` VARCHAR(45) NULL COMMENT 'Caminho da imagem para o menu desabilitado',
  `disabled` VARCHAR(1) NULL DEFAULT 'N' COMMENT 'Informa se o item de menu está desativado ou não. N = Item de menu aparece e pode ser usado, S = Item de menu aparece e NÃO pode ser usado.',
  `hotkey` VARCHAR(45) NULL COMMENT 'Tecla de atalho',
  `boolSeparator` TINYINT NULL,
  `jsonParams` VARCHAR(300) NULL,
  `sit_ativo` VARCHAR(1) NOT NULL DEFAULT 'S' COMMENT 'Informa se o registro está ativo ou não. N = Item de menu nem aparece, S = Item menu aparece.',
  `dat_inclusao` DATETIME NOT NULL DEFAULT NOW(),
  `dat_update` DATETIME NULL DEFAULT now() ON UPDATE now() COMMENT 'data de update igual inclusao implica que nunca teve alteração',
  PRIMARY KEY (`idmenu`),
  INDEX `fk_acesso_menu_pai_idx` (`idmenu_pai` ASC),
  CONSTRAINT `fk_acesso_menu_pai`
    FOREIGN KEY (`idmenu_pai`)
    REFERENCES `acesso_menu` (`idmenu`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `acesso_perfil_menu`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `acesso_perfil_menu` ;

CREATE TABLE IF NOT EXISTS `acesso_perfil_menu` (
  `idperfilmenu` INT NOT NULL AUTO_INCREMENT,
  `idperfil` INT NOT NULL,
  `idmenu` INT NOT NULL,
  `sit_ativo` VARCHAR(1) NOT NULL DEFAULT 'S',
  `dat_inclusao` DATETIME NOT NULL DEFAULT NOW(),
  `dat_update` DATETIME NULL DEFAULT now() ON UPDATE now(),
  PRIMARY KEY (`idperfilmenu`),
  INDEX `fk_acesso_perfil_menu_acesso_perfil1_idx` (`idperfil` ASC),
  INDEX `fk_acesso_perfil_menu_acesso_menu1_idx` (`idmenu` ASC),
  CONSTRAINT `fk_acesso_perfil_menu_acesso_perfil1`
    FOREIGN KEY (`idperfil`)
    REFERENCES `acesso_perfil` (`idperfil`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_acesso_perfil_menu_acesso_menu1`
    FOREIGN KEY (`idmenu`)
    REFERENCES `acesso_menu` (`idmenu`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `acesso_perfil_user`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `acesso_perfil_user` ;

CREATE TABLE IF NOT EXISTS `acesso_perfil_user` (
  `idperfiluser` INT NOT NULL AUTO_INCREMENT,
  `idperfil` INT NOT NULL,
  `iduser` INT NOT NULL,
  `sit_ativo` VARCHAR(1) NOT NULL DEFAULT 'S',
  `dat_inclusao` DATETIME NOT NULL DEFAULT NOW(),
  `dat_update` DATETIME NULL DEFAULT now() ON UPDATE now(),
  PRIMARY KEY (`idperfiluser`),
  INDEX `fk_acesso_perfil_user_acesso_user1_idx` (`iduser` ASC),
  INDEX `fk_acesso_perfil_user_acesso_perfil1_idx` (`idperfil` ASC),
  CONSTRAINT `fk_acesso_perfil_user_acesso_user1`
    FOREIGN KEY (`iduser`)
    REFERENCES `acesso_user` (`iduser`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_acesso_perfil_user_acesso_perfil1`
    FOREIGN KEY (`idperfil`)
    REFERENCES `acesso_perfil` (`idperfil`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `natureza_juridica`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `natureza_juridica` ;

CREATE TABLE IF NOT EXISTS `natureza_juridica` (
  `idnatureza_juridica` INT NOT NULL AUTO_INCREMENT,
  `nom_natureza_juridicac` VARCHAR(300) NOT NULL COMMENT 'Natureza Jurídica ',
  `administradores` VARCHAR(1000) NULL COMMENT 'Integrantes do Quadro de Sócios e Administradores ',
  PRIMARY KEY (`idnatureza_juridica`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `pessoa_juridica`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `pessoa_juridica` ;

CREATE TABLE IF NOT EXISTS `pessoa_juridica` (
  `idpessoa_juridica` INT NOT NULL AUTO_INCREMENT,
  `cnpj` VARCHAR(14) NOT NULL,
  `idpessoa` INT NOT NULL,
  `cnae` INT NULL COMMENT 'códigos de atividades econômicas em todo o país',
  `idnatureza_juridica` INT NULL,
  PRIMARY KEY (`idpessoa_juridica`),
  INDEX `fk_pessoa_juridica_pessoa1_idx` (`idpessoa` ASC),
  INDEX `fk_pessoa_juridica_natureza_juridica1_idx` (`idnatureza_juridica` ASC),
  CONSTRAINT `fk_pessoa_juridica_pessoa1`
    FOREIGN KEY (`idpessoa`)
    REFERENCES `pessoa` (`idpessoa`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_pessoa_juridica_natureza_juridica1`
    FOREIGN KEY (`idnatureza_juridica`)
    REFERENCES `natureza_juridica` (`idnatureza_juridica`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `marca`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `marca` ;

CREATE TABLE IF NOT EXISTS `marca` (
  `idmarca` INT NOT NULL AUTO_INCREMENT,
  `nom_marca` VARCHAR(45) NULL,
  `idpessoa` INT NOT NULL,
  PRIMARY KEY (`idmarca`),
  INDEX `fk_marca_pessoa_idx` (`idpessoa` ASC),
  CONSTRAINT `fk_marca_pessoa1`
    FOREIGN KEY (`idpessoa`)
    REFERENCES `pessoa` (`idpessoa`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `produto`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `produto` ;

CREATE TABLE IF NOT EXISTS `produto` (
  `idproduto` INT NOT NULL AUTO_INCREMENT,
  `nom_produto` VARCHAR(45) NOT NULL,
  `modelo` VARCHAR(45) NOT NULL,
  `versao` VARCHAR(45) NOT NULL,
  `idmarca` INT NOT NULL,
  `idtipo_produto` INT NOT NULL,
  PRIMARY KEY (`idproduto`),
  INDEX `fk_produto_marca1_idx` (`idmarca` ASC),
  INDEX `fk_produto_tipo1_idx` (`idtipo_produto` ASC),
  CONSTRAINT `fk_produto_marca1`
    FOREIGN KEY (`idmarca`)
    REFERENCES `marca` (`idmarca`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_produto_tipo1`
    FOREIGN KEY (`idtipo_produto`)
    REFERENCES `tipo` (`idtipo`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `pedido`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `pedido` ;

CREATE TABLE IF NOT EXISTS `pedido` (
  `idpedido` INT NOT NULL AUTO_INCREMENT,
  `idpessoa` INT NOT NULL COMMENT 'Pessoa que irá receber o pagamento',
  `dat_pedido` DATETIME NOT NULL,
  `idtipo_pagamento` INT NOT NULL,
  PRIMARY KEY (`idpedido`),
  INDEX `fk_pedido_tipo1_idx` (`idtipo_pagamento` ASC),
  INDEX `fk_pedido_pessoa1_idx` (`idpessoa` ASC),
  CONSTRAINT `fk_pedido_tipo1`
    FOREIGN KEY (`idtipo_pagamento`)
    REFERENCES `tipo` (`idtipo`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_pedido_pessoa1`
    FOREIGN KEY (`idpessoa`)
    REFERENCES `pessoa` (`idpessoa`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `pedido_item`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `pedido_item` ;

CREATE TABLE IF NOT EXISTS `pedido_item` (
  `idpedido_item` INT NOT NULL AUTO_INCREMENT,
  `idpedido` INT NOT NULL,
  `idproduto` INT NOT NULL,
  `qtd_unidade` INT NOT NULL,
  `preco` FLOAT NOT NULL,
  PRIMARY KEY (`idpedido_item`),
  INDEX `fk_pedido_item_pedido1_idx` (`idpedido` ASC),
  INDEX `fk_pedido_item_produto1_idx` (`idproduto` ASC),
  CONSTRAINT `fk_pedido_item_pedido1`
    FOREIGN KEY (`idpedido`)
    REFERENCES `pedido` (`idpedido`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_pedido_item_produto1`
    FOREIGN KEY (`idproduto`)
    REFERENCES `produto` (`idproduto`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `endereco`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `endereco` ;

CREATE TABLE IF NOT EXISTS `endereco` (
  `idendereco` INT NOT NULL AUTO_INCREMENT,
  `endereco` VARCHAR(300) NOT NULL,
  `idpessoa` INT NOT NULL,
  `idtipo_endereco` INT NOT NULL,
  `cod_municipio` INT NOT NULL COMMENT 'código do municipio',
  `cep` VARCHAR(8) NULL,
  `numero` VARCHAR(5) NULL,
  `complemento` VARCHAR(300) NULL,
  `bairro` VARCHAR(300) NULL,
  `cidade` VARCHAR(300) NULL,
  PRIMARY KEY (`idendereco`),
  INDEX `fk_endereco_pessoa1_idx` (`idpessoa` ASC),
  INDEX `fk_endereco_tipo1_idx` (`idtipo_endereco` ASC),
  INDEX `fk_endereco_municipio1_idx` (`cod_municipio` ASC),
  CONSTRAINT `fk_endereco_pessoa1`
    FOREIGN KEY (`idpessoa`)
    REFERENCES `pessoa` (`idpessoa`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_endereco_tipo1`
    FOREIGN KEY (`idtipo_endereco`)
    REFERENCES `tipo` (`idtipo`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_endereco_municipio1`
    FOREIGN KEY (`cod_municipio`)
    REFERENCES `municipio` (`cod_municipio`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `telefone`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `telefone` ;

CREATE TABLE IF NOT EXISTS `telefone` (
  `idtelefone` INT NOT NULL AUTO_INCREMENT,
  `numero` VARCHAR(45) NOT NULL,
  `idpessoa` INT NOT NULL COMMENT 'dono do telefone',
  `idtipo_telefone` INT NOT NULL COMMENT 'tipo de telefon',
  `idendereco` INT NULL,
  `sit_fixo` CHAR(1) NULL,
  `whastapp` CHAR(1) NULL COMMENT 'informa se o numero tem whastapp',
  `telegram` CHAR(1) NULL COMMENT 'informa se o numero tem telegram',
  PRIMARY KEY (`idtelefone`),
  INDEX `fk_telefone_pessoa1_idx` (`idpessoa` ASC),
  INDEX `fk_telefone_tipo1_idx` (`idtipo_telefone` ASC),
  INDEX `fk_telefone_endereco1_idx` (`idendereco` ASC),
  CONSTRAINT `fk_telefone_pessoa1`
    FOREIGN KEY (`idpessoa`)
    REFERENCES `pessoa` (`idpessoa`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_telefone_tipo1`
    FOREIGN KEY (`idtipo_telefone`)
    REFERENCES `tipo` (`idtipo`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_telefone_endereco1`
    FOREIGN KEY (`idendereco`)
    REFERENCES `endereco` (`idendereco`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

USE `form_exemplo` ;


-- -----------------------------------------------------
-- procedure selFilhosMenu
-- -----------------------------------------------------

USE `form_exemplo`;
DROP procedure IF EXISTS `selFilhosMenu`;

DELIMITER $$
USE `form_exemplo`$$
/****
SET @idmenu_pai = 1;
CALL selFilhosMenu(@idmenu_pai);
****/
CREATE PROCEDURE `selFilhosMenu`(IN idmenu_pai INT)
BEGIN
  SELECT am.`idmenu`,
      am.`nom_menu`,
      am.`idmenu_pai`,
      am.`url`,
      am.`tooltip`,
      am.`img_menu`,
      am.`imgdisabled`,
      am.`disabled`,
      am.`hotkey`,
      am.`boolSeparator`,
      am.`jsonParams`,
      am.`sit_ativo`,
      am.`dat_inclusao`,
      am.`dat_update`
  FROM `acesso_menu` as am
  where am.idmenu_pai = @idmenu_pai;
END$$

DELIMITER ;

-- -----------------------------------------------------
-- procedure selMenuQtd
-- -----------------------------------------------------

USE `form_exemplo`;
DROP procedure IF EXISTS `selMenuQtd`;

DELIMITER $$
USE `form_exemplo`$$
/***
CALL selMenuQtd(@qtd);
SELECT @qtd;
****/
CREATE PROCEDURE `selMenuQtd`(OUT qtd INT)
BEGIN
  SELECT count(*) into qtd FROM `acesso_menu` as am;
END$$

DELIMITER ;

-- -----------------------------------------------------
-- procedure selFilhosMenuQtd
-- -----------------------------------------------------

USE `form_exemplo`;
DROP procedure IF EXISTS `selFilhosMenuQtd`;

DELIMITER $$
USE `form_exemplo`$$
/***
SET @idmenu_pai = 1;
CALL selFilhosMenuQtd(@qtd, @idmenu_pai);
SELECT @qtd;
****/
CREATE PROCEDURE `selFilhosMenuQtd`(OUT qtd INT, IN idmenu_pai INT)
BEGIN
  SELECT count(*) into qtd
  FROM `acesso_menu` as am
  where am.idmenu_pai = @idmenu_pai;
END$$

DELIMITER ;

-- -----------------------------------------------------
-- View `vw_acesso_user_menu`
-- -----------------------------------------------------
USE `form_exemplo`;
DROP VIEW IF EXISTS `vw_acesso_user_menu` ;
CREATE  OR REPLACE VIEW `vw_acesso_user_menu` AS
  select 
      u.iduser
      ,u.login_user
      ,p.idperfil
      ,p.nom_perfil
      ,m.idmenu
      ,m.nom_menu
  from
       acesso_menu as m
      ,acesso_perfil_menu as pm
      ,acesso_perfil as p
      ,acesso_perfil_user as pu
      ,acesso_user as u
  where 
      m.idmenu = pm.idmenu
  and pm.idperfil = p.idperfil
  and pm.idperfil = pu.idperfiluser
  and pu.iduser = u.iduser;

-- -----------------------------------------------------
-- View `vw_regiao_municipio`
-- -----------------------------------------------------
USE `form_exemplo`;
DROP VIEW IF EXISTS `vw_regiao_municipio` ;
CREATE  OR REPLACE VIEW `vw_regiao_municipio` AS
select r.cod_regiao
	,r.nom_regiao
	,u.cod_uf
	,u.nom_uf
	,u.sig_uf
	,m.cod_municipio
	,m.nom_municipio
	,m.sit_ativo
from regiao as r
	,uf u
	,municipio as m
where u.cod_regiao = r.cod_regiao
and m.cod_uf = u.cod_uf;

-- -----------------------------------------------------
-- View `vw_pessoa`
-- -----------------------------------------------------
USE `form_exemplo`;
DROP VIEW IF EXISTS `vw_pessoa` ;
CREATE  OR REPLACE VIEW `vw_pessoa` AS

SELECT p.idpessoa
	,IFNULL(pf.cpf, pj.cnpj) as cpfcnpj
	,p.nome
	,p.tipo
	,p.sit_ativo
	,p.dat_inclusao
	,DATE_FORMAT(p.dat_inclusao, '%d/%m/%Y') as dat_inclusao_format
	,pf.cpf
	,pf.idpessoa_fisica
	,pf.cod_municipio_nascimento
	,pf.dat_nascimento
	,DATE_FORMAT(pf.dat_nascimento, '%d/%m/%Y') as dat_nascimento_format
	,pj.idnatureza_juridica
	,pj.cnpj
FROM 
	pessoa as p
	left join pessoa_fisica as pf
	on p.idpessoa = pf.idpessoa
	left join pessoa_juridica as pj
	on p.idpessoa = pj.idpessoa;


-- -----------------------------------------------------
-- View `vw_pessoa`
-- -----------------------------------------------------
USE `form_exemplo`;
DROP VIEW IF EXISTS `vw_pessoa_fisica` ;
CREATE  OR REPLACE VIEW `vw_pessoa_fisica` AS

SELECT p.idpessoa
      ,p.nome
	    ,p.tipo
	    ,p.sit_ativo
	    ,pf.cpf
      ,pf.rg	
      ,m.cod_uf
      ,m.nom_uf
      ,m.sig_uf
      ,pf.cod_municipio_nascimento
      ,m.nom_municipio
	    ,pf.dat_nascimento
	    ,DATE_FORMAT(pf.dat_nascimento, '%d/%m/%Y') as dat_nascimento_format
      ,pf.idpessoa_fisica
	    ,p.dat_inclusao   
      ,p.dat_alteracao
FROM 
	pessoa as p
	left join pessoa_fisica as pf
	on p.idpessoa = pf.idpessoa
	left join vw_regiao_municipio as m
    on pf.cod_municipio_nascimento = m.cod_municipio
where p.tipo = 'PF'

-- -----------------------------------------------------
-- View `vw_pessoa_marca_produto`
-- -----------------------------------------------------
USE `form_exemplo`;
DROP VIEW IF EXISTS `vw_pessoa_marca_produto` ;
CREATE  OR REPLACE VIEW `vw_pessoa_marca_produto` AS
select pe.idpessoa
      ,pe.nome
      ,m.idmarca
      ,m.nom_marca
      ,pr.idproduto
      ,pr.nom_produto
from pessoa as pe
join marca as m on pe.idpessoa = m.idpessoa
left join produto as pr on m.idmarca = pr.idmarca;

SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;