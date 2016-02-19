-- MySQL Script generated by MySQL Workbench
-- 01/21/16 21:32:55
-- Model: New Model    Version: 1.0
-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema mydb
-- -----------------------------------------------------
-- -----------------------------------------------------
-- Schema workshopsalfacollege_com
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Table `Soortcursus`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Soortcursus` (
  `soortcode` INT(3) NOT NULL COMMENT '',
  `cursussoort` VARCHAR(100) NULL COMMENT '',
  `prijs` INT(10) NULL COMMENT '',
  PRIMARY KEY (`soortcode`)  COMMENT '',
  UNIQUE INDEX `cursussoort_UNIQUE` (`cursussoort` ASC)  COMMENT '')
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Cursus`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Cursus` (
  `cursuscode` INT(3) NOT NULL COMMENT '',
  `begindatum` DATE NULL COMMENT '',
  `einddatum` DATE NULL COMMENT '',
  `soort_cursus` INT(3) NULL COMMENT '',
  PRIMARY KEY (`cursuscode`)  COMMENT '',
  UNIQUE INDEX `soort_cursus_UNIQUE` (`soort_cursus` ASC)  COMMENT '',
  CONSTRAINT `SoortCursus`
    FOREIGN KEY (`soort_cursus`)
    REFERENCES `Soortcursus` (`soortcode`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Cursist`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Cursist` (
  `id` INT(3) NOT NULL COMMENT '',
  `email_adres` VARCHAR(100) NOT NULL COMMENT '',
  `roepnaam` VARCHAR(20) NULL COMMENT '',
  `tussenvoegsels` VARCHAR(8) NULL COMMENT '',
  `achternaam` VARCHAR(100) NULL COMMENT '',
  `adres` VARCHAR(100) NULL COMMENT '',
  `woonplaats` VARCHAR(100) NULL COMMENT '',
  `telefoon` VARCHAR(12) NULL COMMENT '',
  PRIMARY KEY (`id`)  COMMENT '',
  UNIQUE INDEX `email_adres_UNIQUE` (`email_adres` ASC)  COMMENT '')
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `CursistCursus`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `CursistCursus` (
  `cursuscode` INT(3) NOT NULL COMMENT '',
  `cursist` INT(3) NULL COMMENT '',
  PRIMARY KEY (`cursuscode`)  COMMENT '',
  UNIQUE INDEX `cursist_UNIQUE` (`cursist` ASC)  COMMENT '',
  CONSTRAINT `cursistCursusCursist`
    FOREIGN KEY (`cursist`)
    REFERENCES `Cursist` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `cursistCursusCursus`
    FOREIGN KEY (`cursuscode`)
    REFERENCES `Cursus` (`cursuscode`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;